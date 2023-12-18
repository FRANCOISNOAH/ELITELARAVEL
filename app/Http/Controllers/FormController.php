<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\Conditional;
use App\Models\Conditional_field;
use App\Models\FormField;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use stdClass;
use function Symfony\Component\Translation\t;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $current_user = auth()->user();
        $forms = $current_user->forms()->latest()->get();
        return view('forms.form.index', compact('forms', 'current_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $current_user = Auth::user();
        return view('forms.form.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $current_user = Auth::user();
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'description' => 'required|string|max:30000'
        ]);
        $form = new Form([
            'title' => ucfirst($request->title),
            'description' => ucfirst($request->description),
            'status' => Form::STATUS_DRAFT
        ]);

        $form->generateCode();
        $current_user->forms()->save($form);
        return redirect()->route('forms.show', $form->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $current_user = Auth::user();
        $form->load('fields', 'availability');
        return view('forms.form.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $current_user = Auth::user();
        return view('forms.form.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $current_user = Auth::user();
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'description' => 'required|string|min_words:3|max:30000'
        ]);

        $form->title = $request->title;
        $form->description = $request->description;
        $form->save();
        return redirect()->route('forms.show', $form->code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        if (request()->ajax()) {
            $form = Form::where('code', $form)->first();
            if (!$form || $form->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'not_found',
                    'error' => 'Form is invalid'
                ]);
            }
            if ($form->status === Form::STATUS_OPEN) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'not_allowed',
                    'error' => 'Form cannot be deleted as it is still open. Close it first.'
                ]);
            }
            $form->delete();
            return response()->json([
                'success' => true,
            ]);
        }

        $form = Form::where('code', $form)->firstOrFail();
        $not_allowed = ($form->user_id !== Auth::id());
        abort_if($not_allowed, 404);
        $not_allowed = ($form->status === Form::STATUS_OPEN);
        abort_if($not_allowed, 403);
        $form->delete();
        session()->flash('index', [
            'status' => 'success',
            'message' => 'Form has been deleted'
        ]);
        return redirect()->route('forms.index');
    }


    /**
     * @param Request $request
     * @param $form
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function draftForm(Request $request, $form)
    {
        if ($request->ajax()) {
            $form = Form::where('code', $form)->with('fields')->first();

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' => 'Form is invalid',
                ]);
            }

            $inputs = [];
            $is_invalid_request = false;
            foreach ($request->except('_token') as $key => $value) {
                $key_parts = explode('_', $key);

                if (!is_array($key_parts) || count($key_parts) < 3) {
                    $is_invalid_request = true;
                    break;
                }

                $key_parts = array_reverse($key_parts);
                $field = array_shift($key_parts);
                $unique_key = array_shift($key_parts);
                $template = implode('_', array_reverse($key_parts));

                if (!in_array(str_replace('_', '-', $template), get_form_templates()->pluck('alias')->all())) {
                    $is_invalid_request = true;
                    break;
                }

                if ($template === 'linear_scale') {
                    $sub_key = substr($field, 0, 3);
                    if (in_array($sub_key, ['min', 'max'])) {
                        $field = "options.{$sub_key}." . substr($field, 3);
                    }
                }

                $new_key = "{$template}.{$unique_key}.{$field}";

                $inputs = Arr::add($inputs, $new_key, $value);
            }

            if ($is_invalid_request) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' => 'Invalid request made. Please refresh the page'
                ]);
            }

            $validator = Validator::make($inputs, [
                'short_answer.*.question' => 'sometimes|required|string|min:3|max:255',
                'long_answer.*.question' => 'sometimes|required|string|min:3|max:60000',
                'multiple_choices.*.question' => 'sometimes|required|string|min:3|max:255',
                'multiple_choices.*.options.*' => 'required_with:multiple_choices.*.question|string|min:3|max:255',
                'checkboxes.*.question' => 'sometimes|required|string|min:3|max:255',
                'checkboxes.*.options.*' => 'required_with:checkboxes.*.question|string|min:3|max:255',
                'drop_down.*.question' => 'sometimes|required|string|min:3|max:255',
                'drop_down.*.options.*' => 'required_with:drop_down.*.question|string|min:3|max:255',
                'linear_scale.*.question' => 'sometimes|required|string|min:3|max:255',
                'linear_scale.*.options.min.value' => 'required_with:linear_scale.*.question|integer|in:0,1',
                'linear_scale.*.options.min.label' => 'nullable|string|min:3|max:255',
                'linear_scale.*.options.max.value' => 'required_with:linear_scale.*.question|integer|in:' . implode(',', range(2, 10)),
                'linear_scale.*.options.max.label' => 'nullable|string|min:3|max:255',
                'date.*.question' => 'sometimes|required|string|min:3|max:255',
                'time.*.question' => 'sometimes|required|string|min:3|max:255',
            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten();
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' => $errors->first()
                ]);
            }

            foreach ($form->fields as $field) {
                $field->question = ucfirst(data_get($inputs, "{$field->attribute}.question"));
                if (data_get($inputs, "{$field->attribute}.required") === "on") {
                    $field->required = true;
                }
                $field->options = data_get($inputs, "{$field->attribute}.options");
                $field->filled = true;
                $field->save();
            }

            ($form->status === Form::STATUS_DRAFT) and $form->status = Form::STATUS_PENDING;
            $form->save();

            return response()->json([
                'success' => true,
            ]);
        }
    }

    /**
     * @param Form $form
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function previewForm(Form $form): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $current_user = Auth::user();
        return view('forms.form.view_form', ['form' => $form, 'view_type' => 'preview']);
    }

    /**
     * @param Form $form
     * @return RedirectResponse
     */
    public function openFormForResponse(Form $form): RedirectResponse
    {
        $current_user = Auth::user();
        $not_allowed = ($form->user_id !== $current_user->id);
        abort_if($not_allowed, 403);

        $not_allowed = (!in_array($form->status, [Form::STATUS_PENDING, Form::STATUS_CLOSED]));
        abort_if($not_allowed, 403);

        $form->status = Form::STATUS_OPEN;
        $form->save();

        session()->flash('show', [
            'status' => 'success',
            'message' => 'Your form is now open to receive responses. You can now share it with other people.',
        ]);

        return redirect()->route('forms.show', $form->code);
    }

    /**
     * @param Form $form
     * @return RedirectResponse
     */
    public function closeFormToResponse(Form $form): RedirectResponse
    {
        $current_user = Auth::user();
        $not_allowed = ($form->user_id !== $current_user->id);
        abort_if($not_allowed, 403);

        $not_allowed = ($form->status !== Form::STATUS_OPEN);
        abort_if($not_allowed, 403);

        $form->status = Form::STATUS_CLOSED;
        $form->save();

        session()->flash('show', [
            'status' => 'success',
            'message' => 'The form has been successfully closed. You can reopen it if you want to.',
        ]);

        return redirect()->route('forms.show', $form->code);
    }

    /**
     * @param Form $form
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function viewForm(Form $form): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $not_allowed = !in_array($form->status, [Form::STATUS_OPEN, Form::STATUS_CLOSED]);
        abort_if($not_allowed, 404);
        $conditions = Conditional_field::with('conditionals')->where('form_id', $form->id)->get();
        return view('forms.form.view_form', ['form' => $form, 'conditions' => $conditions, 'view_type' => 'form']);
    }


    public function conditional(Form $form)
    {
        $questions = collect();
        $questions = FormField::where('form_id', $form->id)
            ->get();

        return view('operation.conditional', compact('questions'));
    }


    public function conditionalpost(Request $request)
    {
        $questions = $request["questions_check"];
        $question = $request['question'];
        $value = $request['value'];
        if ($questions == null) {
            return back()->withErrors('VEUILLEZ SELECTIONNER UNE QUESTION A AFFICHER QUAND LA CONDITION EST VERIFER');
        } else {
            foreach ($questions as $item) {
                FormField::where('id', $item)->update(['display' => 'none']);
            }
        }

        $field = FormField::find($question);

        //Enregistrement de la condition
        $conditional = new Conditional();
        $conditional->form_id = $field->form_id;
        $conditional->field_id = $field->id;
        $conditional->field_name = $field->attribute;
        $conditional->value = $value;
        $conditional->display = "contents";
        $conditional->save();

        //Enregistrement des questions liees a la conditions
        foreach ($questions as $item) {
            $conditional_fields = new Conditional_field();
            $conditional_fields->conditional_id = $conditional->id;
            $conditional_fields->field_id = $item;
            $conditional_fields->save();
        }

        return back()->withSuccess(trans('Saved condition'));

    }


    public function getResponse($question)
    {
        $options = collect();
        $responses = FormField::find($question);
        $Alloptions = $responses->options;
        foreach ($Alloptions as $key => $value) {
            $object = new stdClass();
            $object->id = $key;
            $object->value = $value;
            $options->push($object);
        }
        return response()->json($options);
    }
}
