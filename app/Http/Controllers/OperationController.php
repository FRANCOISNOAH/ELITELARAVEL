<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Form;
use App\Models\Operation;
use App\Models\OperationUserSave;
use App\Models\Topic;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('SuperAdmin'))
            $operations = Operation::all();
        else {
            $operations = Operation::where("user_id", auth()->user()->id)->get();
        }
        return view('admin.operation.index', compact('operations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operation.step1');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $current_user = Auth::user();
        $request->validate([
            'name' => 'required',
            'profils' => 'required',
            'operators' => 'required|integer|min:0',
            'message' => 'required|string',
            'dateDebut' => 'required|date|after_or_equal:' . Date::now()->toDateString(),
            'dateFin' => 'required|date|after_or_equal:dateDebut',
        ]);
        $form = new Form([
            'title' => ucfirst($request->name),
            'status' => Form::STATUS_DRAFT,
            "start" => $request->dateDebut,
            "end" => $request->dateFin,
            "message" => $request->message
        ]);
        $form->generateCode();
        $form->save();
        $operation = new Operation([
            "user_id" => $current_user->id,
            "form_id" => $form->id,
            "operators" => $request->operators,
            "profils" => $request->profils
        ]);
        $operation->save();

        if ($request->ajax()) {
            $redirectRoute = route('operation.second', [
                'operation' => $operation,
            ]);
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('operation.second', [
                'operation' => $operation,
            ])->with('success', 'Utilisateur crée avec succès.');
        }
    }


    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function second_step($id)
    {
        $operation = Operation::with('form', 'users', 'sites')->find($id);
        return view('admin.operation.step2', [
            "operation" => $operation,
            "form" => $operation->form,
            "sites" => $operation->sites
        ]);
    }


    public function operation_sites($id)
    {
        $operation = Operation::with('sites')->find($id);
        if (isset($operation)) {
            $sites = $operation->sites()->with('country', 'city')->get();
        } else {
            $sites = null;
        }
        return view('admin.operation.map', compact('sites', 'operation'));
    }

    /**
     * @param Operation $operation
     * @return \Illuminate\Http\JsonResponse
     */
    public function operation_sites_json($id)
    {
        $operation = Operation::with('sites')->find($id);
        if (isset($operation)) {
            $sites = $operation->sites()->get();
        } else {
            $sites = null;
        }
        return response()->json($sites);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array|Application|Factory|\Illuminate\View\View
     */
    public function show(int $id, Request $request): Factory|array|\Illuminate\View\View|Application
    {

            $tokens = null;
            $Villes = collect();
            $operation = Operation::with('sites')->find($id);
            $sites = $operation->sites()->get();

            foreach ($operation->sites()->get()->GroupBy('city_id') as $site)
            {
                $ville = City::find($site->first()->city_id);
                $Villes->push($ville);
            }
            $current_user = Auth::user();
            $form = $operation->form;
            $valid_request_queries = ['summary', 'individual'];
            $query = strtolower(request()->query('type', 'summary'));

            abort_if(!in_array($query, $valid_request_queries), 404);

            if ($query === 'summary') {
                $responses = [];

                $form->load('fields.responses');

            } else {
                $form->load('collaborationUsers');
                $responses = $form->responses()->has('fieldResponses')->paginate(1, ['*'], 'response');
            }

            $data_for_chart = [];
            $fields = $form->fields;
            foreach ($fields as $field) {
                $response_for_chart = $field->getResponseSummaryDataForChart();
                if (!empty($response_for_chart)) {
                    $data_for_chart[] = $response_for_chart;
                }
            }

            $data_for_chart2 = [];
            $fields = $form->fields;
            foreach ($fields as $field) {
                $response_for_chart = $field->getResponseSummaryDataForChart2();
                if (!empty($response_for_chart)) {
                    $data_for_chart2[] = $response_for_chart;
                }
            }

            $view = (string)\Illuminate\Support\Facades\View::make('admin.operation.partials.response', compact('operation', 'form', 'responses'));
            $viewprint = (string)\Illuminate\Support\Facades\View::make('admin.operation.partials.responseprint', compact('operation', 'form','responses'));
            //$viewoperateurs = (string)\Illuminate\Support\Facades\View::make('operation.partials.responseoperateur', compact('operation'));
            $viewoperateurs= null;


            if (auth()->user()->roles->pluck('id')[0] === 1 || auth()->user()->roles->pluck('id')[0] === 2) {
                $operateurs = User::role('Operateur')->with('roles', 'country','city','company')
                    ->where('company_id', null)->get();
            } else {
                $operateurs = User::role('Operateur')->with('roles', 'country','city','company')
                    ->where('company_id', auth()->user()->company_id)->get();
            }

            $lecteurs =  $operation->usersWithRole('Lecteur');
            $operateurs = $operation->usersWithRole('Operateur');

            if ($request->ajax()) {
                return [
                    'response_view' => $view,
                    'data_for_chart' => json_encode($data_for_chart),
                    'response_view2' => $viewprint,
                    'data_for_chart2' => json_encode($data_for_chart2),
                    'response_operateurs' => $viewoperateurs,
                    'tokens' => $tokens,
                    'operateurs' => $operateurs,
                    'lecteurs' => $lecteurs,
                    'sites' => $sites
                ];
            } else {
                return view('admin.operation.show',
                    compact('view','viewprint', 'operation', 'form',
                        'query', 'responses','sites','data_for_chart',
                        'data_for_chart2','Villes',
                        'operateurs','lecteurs'
                    )
                );
            }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operation $operation)
    {
        return view("admin.operation.edit", compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operation $operation)
    {
        $current_user = Auth::user();
        $request->validate([
            'name' => 'required',
            'profils' => 'required',
            'operators' => 'required|integer|min:0',
            'message'=>'required|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
        ]);

        $form = $operation->form;
        $form->title = ucfirst($request->name);
        $form->start = $request->dateDebut;
        $form->end = $request->dateFin;
        $form->message = $request->message;
        $form->update();

        $operation->operators = $request->operators ;
        $operation->profils = $request->profils;
        $operation->update();

        if ($request->ajax()) {
            $redirectRoute = route('operation.second', [
                'operation' => $operation,
            ]);
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('operation.second', [
                'operation' => $operation,
            ])->with('success', 'Utilisateur crée avec succès.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation)
    {
        //
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function third_step(Request $request)
    {
        $request->validate([
            'heure_debut' => 'date_format:H:i',
            'heure_fin' => 'date_format:H:i|after:heure_debut',
            'operation_id' => 'required|integer|min:1',
        ]);
        $id = $request["operation_id"];

        $operation = Operation::with('form', 'users', 'sites')->find($id);
        $form = Form::find($operation->form->id);
        if (isset($request["start_hour"]) && isset($request["end_hour"])) {
            $form->start_time = $request["start_hour"];
            $form->end_time = $request["end_hour"];
            $form->save();
        }

        if ($request->ajax()) {
            $redirectRoute = route('operation.third.view',['operation' => $operation]);
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('operation.third.view',['operation' => $operation])->with('success', 'Utilisateur crée avec succès.');
        }
    }


    public function view_third_step($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $operation = Operation::with('form', 'users', 'sites')->find($id);
        $form = Form::find($operation->form->id);
        $topics = Topic::all();
        $sites = $operation->sites;
        return view("admin.operation.step3",compact(['sites','operation','form','topics']));
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function start($id): JsonResponse
    {
        $form = Form::find($id);
        $form->status = FORM::STATUS_OPEN;
        $form->update();
        return response()->json(['status' => 'success']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function end($id): JsonResponse
    {
        $form = Form::find($id);
        $form->status = FORM::STATUS_CLOSED;
        $form->update();
        return response()->json(['status' => 'success']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addOperateurs(Request $request)
    {
        $request->validate([
            'operation' => 'required|integer',
            'operateurs' => 'required|array',
        ]);
        $operation = Operation::find($request['operation']);
        $operateurs = collect();
        foreach ($request['operateurs'] as $item){
            $user = User::find($item);
            $operation->users()->attach((int) $item);
            $save = new OperationUserSave();
            $save->user_id = $user->id ;
            $save->operation_id = $operation->id;
            $save->activated = true;
            $save->save();
        }
        return back();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getOperateursList($id)
    {
        $operation = Operation::find($id);
        if (auth()->user()->roles->pluck('id')[0] === 1 || auth()->user()->roles->pluck('id')[0] === 2) {
            $operateurs = User::role('Operateur')->with('roles', 'country','city','company')
                ->where('company_id', null)->get();
        } else {
            $operateurs = User::role('Operateur')->with('roles', 'country','city','company')
                ->where('company_id', auth()->user()->company_id)->get();
        }

        $viewprint = (string)\Illuminate\Support\Facades\View::make('Helpers.OperateursList', compact('operation', 'operateurs'));


        return \response()->json($viewprint);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getLecteursList($id){

        $operation = Operation::find($id);
        if (auth()->user()->roles->pluck('id')[0] === 1 || auth()->user()->roles->pluck('id')[0] === 2) {
            $lecteurs = User::role('Lecteur')->with('roles', 'country','city','company')
                ->where('company_id', null)->get();
        } else {
            $lecteurs = User::role('Lecteur')->with('roles', 'country','city','company')
                ->where('company_id', auth()->user()->company_id)->get();
        }

        $viewprint = (string)\Illuminate\Support\Facades\View::make('Helpers.LecteursList', compact('operation', 'lecteurs'));

        return \response()->json($viewprint);
    }

    /**
     * @param $user_id
     * @param $operation_id
     * @return true
     */
    public function removeOperateurs($user_id,$operation_id){
        $user = User::find($user_id);
        $operation = Operation::find($operation_id);
        $operation->users()->detach($user);
        /**
         * Nptification avec tout ce qui va avec
         */

        return true;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addLecteurs(Request $request)
    {
        $request->validate([
            'operation' => 'required|integer',
            'lecteurs' => 'required|array',
        ]);
        $operation = Operation::find($request['operation']);
        $operateurs = collect();
        foreach ($request['lecteurs'] as $item){
            $user = User::find($item);
            $operation->users()->attach((int) $item);
            $save = new OperationUserSave();
            $save->user_id = $user->id ;
            $save->operation_id = $operation->id;
            $save->activated = true;
            $save->save();
        }
        return back();
    }


    /**
     * @param $user_id
     * @param $operation_id
     * @return true
     */
    public function removeLecteurs($user_id,$operation_id){
        $user = User::find($user_id);
        $operation = Operation::find($operation_id);
        $operation->users()->detach($user);
        /**
         * Nptification avec tout ce qui va avec
         */

        return true;
    }


}
