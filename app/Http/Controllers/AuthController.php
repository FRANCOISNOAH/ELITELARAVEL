<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Models\Company;
use App\Models\Country;
use App\Models\Form;
use App\Models\SignHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password as PWD;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function register(){
        $countries =  Country::all();
        return view('auth.register',compact('countries'));
    }

    public function saveregister(Request $request)
    {
        /**
         * Validation des entrees de la requettes
         */
        $request->validate([
            'company' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'country' => 'required|integer',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ]);
        /**
         * Creation de l'entreprise
         */
        $company = new Company();
        $company->name = $request["company"];
        $company->save();
        /**
         * Creation du compte
         */
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->country_id = $request['country'];
        $user->company_id = $company->id;
        $user->password = Hash::make($request['password']);
        $user->save();
        /**
         * Envoi de l'email
         */

        $client = Role::findById(4);
        $user->assignRole([$client]);

        Mail::to($request['email'])->send(new RegisterMail());

        if ($request->ajax()) {
            $redirectRoute = route('confirm.register');
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('login.email')->with('success','Compte créer avec succès. Veillez consulter vos emails.');
        }

    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function start($id): RedirectResponse
    {
        $form = Form::find($id);
        $form->status = FORM::STATUS_OPEN;
        $form->update();
        return back()->with('success', 'Operation debuté avec succès.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function end($id): RedirectResponse
    {
        $form = Form::find($id);
        $form->status = FORM::STATUS_CLOSED;
        $form->update();
        return back()->with('success', 'Operation terminé avec succès.');
    }


    public function confirmregister(){
        return view('auth.confirmregister');
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('operation.index');
        } else {
            return view('auth/login');
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function email(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email:rfc,dns']);

            $user = User::where('email', $request['email'])->count();

            if ($user === 0) {
                throw ValidationException::withMessages([
                    'email' => 'Veuillez vérifier vos identifiants'
                ]);
            } else {
                // Assuming you want to return JSON for AJAX requests
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'redirect' => route('password', ['email' => $request['email']])]);
                } else {
                    // Pass the email data to the view
                    return view('auth/password', ['email' => $request['email']]);
                }
            }
        } catch (ValidationException $e) {
            // Handle validation errors for AJAX requests
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()]);
            } else {
                throw $e;
            }
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function loginpassword(Request $request)
    {
        // Use $request->input('email') to get the email from the request
        $email = $request->input('email');
        $user = User::where('email', $email)->count();
        if ($user === 0) {
            return redirect()->route('login');
        } else {
            return view('auth/password', compact('email'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function connect(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'), true)) {
                // Retrieve user information for further actions
                $user = User::where("email", $request['email'])->first();
                $error = SignHistory::where("user_id", $user->id)
                    ->where("description", "Erreur de mot de passe")
                    ->whereDate('created_at', Carbon::today())
                    ->get();
                $error_count = $error->count();

                $error_first = $error->first();

                if ($error_count === 0) {
                    // First login attempt error
                    $errors = new SignHistory();
                    $errors->user_id = $user->id;
                    $errors->description = "Erreur de mot de passe";
                    $errors->error_number = 1;
                    $errors->save();

                    return response()->json([
                        'error' => true,
                        'message' => 'Veuillez vérifier vos identifiants, il vous reste 2 tentatives'
                    ]);
                } elseif ($error_first->error_number == 1) {
                    // Second login attempt error
                    $error_first->error_number++;
                    $error_first->update();

                    return response()->json([
                        'errors' => true,
                        'message' => 'Veuillez vérifier vos identifiants, il vous reste 1 tentative'
                    ]);
                } elseif ($error_first->error_number >= 2) {
                    // Third login attempt error
                    $error_first->error_number++;
                    $error_first->update();

                    // Deactivate the user's account
                    $user->activated = 0;
                    $user->update();

                    return response()->json([
                        'errors' => true,
                        'message' => 'Votre compte est désactivé. Merci de contacter les équipes de BlooElite.'
                    ]);
                }
            }

            // Check if the user's account is activated
            if (auth()->user()->activated === 0) {
                return response()->json([
                    'errors' => true,
                    'success' => false,
                    'message' => 'Votre compte est désactivé. Merci de contacter les équipes de BlooElite.'
                ]);
            }


            $request->session()->regenerate();
            return response()->json(['success' => true, 'redirect' => route('operation.index')]);

        } catch (ValidationException $e) {
            // Return validation error messages in case of validation failure
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        }
    }

    /**
     * @param $email
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function forgot_password($email)
    {
        return view('auth.passwords.email', compact('email'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function submitForgetPasswordForm(Request $request)
    {
        // Validate the request data
        $request->validate(['email' => 'required|email']);

        // Send a password reset link
        $status = PWD::sendResetLink(
            $request->only('email')
        );

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return JSON response with success and message
            return response()->json([
                'success' => $status === PWD::RESET_LINK_SENT,
                'message' => $status === PWD::RESET_LINK_SENT
                    ? 'Nous avons envoyé par e-mail le lien de réinitialisation de votre mot de passe !'
                    : __($status),
            ]);
        }

        // Check the status of the password reset link sending attempt
        return $status === PWD::RESET_LINK_SENT
            ? back()->with('success', 'Nous avons envoyé par e-mail le lien de réinitialisation de votre mot de passe !')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * @param $token
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email:rfc,dns|exists:users',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
            'password_confirmation' => 'required'
        ]);


        $status = PWD::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === PWD::PASSWORD_RESET) {
            if ($request->ajax()) {
                $redirectRoute = route('password.confirm');
                return response()->json(['status' => 'success', 'message' => $status, 'redirect' => $redirectRoute]);
            } else {
                return redirect()->route('login')->with('status', __($status));
            }
        } else {
            $errors = ['email' => [__($status)]];
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $errors], 422);
            } else {
                return back()->withErrors($errors);
            }
        }

    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function confirm(){
        return view('auth.passwords.confirm');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


}
