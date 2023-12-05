<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::role(['SuperAdmin','Admin'])->with('roles','country','company')->get();
        $clients = User::role('Client')->with('roles','country','company')->get();
        $operateurs = User::role('Operateur')->with('roles','country','company')->get();
        $lecteurs = User::role('Lecteur')->with('roles','country','company')->get();

        return view('admin.user.index',compact('admins','clients','operateurs','lecteurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        $clients = User::role('Client')->with('roles','country','company')->get();
        return  view('admin.user.create',compact('roles','countries','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|integer',
            'activate' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'country' => 'required|integer',
            'user_id' => 'integer',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ]);

        $user = new User();
        $user->name = $request["name"];
        $user->email = $request["email"];
        $user->password = Hash::make($request["password"]);
        $user->activated = $request["activate"];
        if(auth()->user()->hasRole('Client')){
            $user->company_id = auth()->user()->company_id;
        }
        $user->country_id = $request["country"];
        if(isset($request['user_id'])){
          $data = User::findOrFail((int) $request['user_id']);
            $user->company_id = $data->company_id;
        }
        $user->save();
        $user->assignRole((int)$request["role"]);

        if ($request->ajax()) {
            $redirectRoute = route('user.index');
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('user.index')->with('success', 'Utilisateur crée avec succès.');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
