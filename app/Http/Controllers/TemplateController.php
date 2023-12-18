<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAvailability;
use App\Models\FormField;
use App\Models\Operation;
use App\Models\Template;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TemplateController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function alltemplates(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $templates = Template::with('form')->where('topic_id', $topic_id)->get();
        $viewData = (string)View::make('Helpers.template', compact('templates'));
        return response()->json($viewData);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function alltemplates3(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $templates = Template::with('form')->where('topic_id', $topic_id)->get();
        return response()->json($templates);

    }

    public function alltemplates2(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $templates = Template::with('form')->where('topic_id', $topic_id)->get();
        $viewData = (string)View::make('helpers.template', compact('templates'));
        return response()->json($viewData);
    }


    public function useblank($id){
        $current_user = Auth::user();
        $operation = Operation::findOrFail($id);
        $form = new Form([
            'title' => $operation->nom,
            'description' => $operation->nom,
            'status' => Form::STATUS_DRAFT,
            'user_id' => auth()->user()->id,
        ]);
        $form->generateCode();
        $form->save();
        $current_user->forms()->save($form);
        $operation->form_id = $form->id;
        $operation->save();
        return redirect()->route('forms.show', [$form->code]);
        //return redirect()->route('theadministration.index');

    }


    public function use($id,$code){
        /**
         * Retrouver les template et l'operation
         */
        $current_user = Auth::user();
        //$template = Template::where('form_id',$id1)->first();
        $theform = Form::with('fields')->where('code',$code)->first();
        $operation = Operation::findOrFail($id);

        /**
         * Mise a jour du fomrulaire;
         */
        $form = Form::findOrFail($operation->form_id);
        $form_id = $form->id;

        /**
         * Enregistremnt des questions;
         */
        foreach($theform->fields as $item) {
            $field = new FormField([
                'template' => $item->template,
                'attribute' => $item->attribute,
                'question' => $item->question,
                'required' => $item->required,
                'options' => $item->options,
                'filled' =>$item->filled
            ]);
            $form->fields()->save($field);
        }

        $redirectRoute = route('forms.show', [$form->code]);
        return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topic.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $current_user = Auth::user();

        $form = new Form([
            'title' => ucfirst($request->name),
            'description' => ucfirst($request->description),
            'status' => Form::STATUS_DRAFT,
            'start' => Carbon::now(),
            'end'=> Carbon::now(),
            'message' => "message"
        ]);



        $form->generateCode();

        //$current_user->forms()->save($form);

        $form->save();

        $template = new Template([
            'form_id' => $form->id ,
            'topic_id' => $request->topic_id
        ]);

        $template->save();
        return redirect()->route('topic.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        //
    }
}
