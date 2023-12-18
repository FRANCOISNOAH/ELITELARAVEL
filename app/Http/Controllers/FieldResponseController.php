<?php

namespace App\Http\Controllers;

use App\Models\FieldResponse;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FieldResponseController extends Controller
{
    /**
     * @param Request $request
     * @param $form
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function store(Request $request, $form)
    {
        if ($request->ajax()) {
            $form = Form::where('code', $form)->first();

            $current_user = Auth::user();
            if (!$form) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' =>  'Form is invalid',
                ]);
            }

            $templates = get_form_templates();


            $validator = Validator::make($request->all(), [
                'template' => 'required|string|in:' . implode(',', $templates->pluck('alias')->all())
            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten();
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' =>  $errors->first()
                ]);
            }

            $attribute_prefix = str_replace('-', '_', $request->template) . '.' . bin2hex(random_bytes(4));

            $field = new FormField([
                'template' => $request->template,
                'attribute' => $attribute_prefix,
                'filled' => false,
            ]);

            $form->fields()->save($field);

            return response()->json([
                'success' => true,
                'data' => [
                    'field' => $field->id,
                    'sub_template' => (get_form_templates($request->template))['sub_template'],
                    'attribute' => $attribute_prefix,
                    'has_options' => (in_array($request->template, $templates->where('attribute_type', 'array')->pluck('alias')->all()))
                ]
            ]);
        }
    }

    /**
     * @param Request $request
     * @param $form
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(Request $request, $form)
    {
        if ($request->ajax()) {
            $form = Form::where('code', $form)->first();

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' =>  'Le formulaire est invalide',
                ]);
            }

            $field = $form->fields()->where('id', $request->form_field)->first();

            if (!$field || $field->form_id !== $form->id) {
                return response()->json([
                    'success' => false,
                    'error_message' => 'validation_failed',
                    'error' =>  "Le champ du formulaire n'est pas valide",
                ]);
            }

            $field->delete();

            if (!$form->fields()->count()) {
                $form->status = Form::STATUS_DRAFT;
                $form->save();
            }

            return response()->json([
                'success' => true
            ]);
        }
    }
}
