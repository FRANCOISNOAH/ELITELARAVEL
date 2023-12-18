<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Site;
use Illuminate\Http\Request;
use stdClass;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            "nom" => "required",
            "rayon" => "required",
            "pays" => "required",
            "ville" => "required",
            "lat" => "required",
            "lng" => "required",
            "operation_id" => "required",
        ]);

        $oldsite = Site::where('lat',$request['lat'])
            ->where('lng',$request['lng'])
            ->where('operation_id',$request['operation_id'])
            ->get()->first();


        if(isset($oldsite)){
            $result = ["Erreur" => "Donnees deja en base"];
            return response()->json($result);
        }else{
            $thecountry = Country::where("name_fr", $request["pays"])
                ->orWhere("name_en", $request["pays"])
                ->get()->first();
            if(isset($thecountry)){
                $thecity = City::where("name",$request["ville"])->get()->first();
                $site = new Site();
                if(isset($thecity)){
                    $site->city_id = $thecity->id;
                }else{
                    $city = new City();
                    $city->name = $request["ville"];
                    $city->country_id = $thecountry->id;
                    $city->save();
                    $site->city_id = $city->id;
                }
                $site->operation_id = (int) $request["operation_id"];
                $site->country_id = $thecountry->id;
                $site->name = $request["nom"];
                $site->rayon = (int) $request["rayon"];
                $site->lat = (double) $request["lat"];
                $site->lng = (double) $request["lng"];
                $site->save();

                $countryresult = Country::find($site->country_id);
                $cityresult = City::find($site->city_id);

                $obj = new stdClass();
                $obj->id = $site->id;
                $obj->nom = $site->name;
                $obj->rayon = $site->rayon;
                $obj->pays = $countryresult->name_fr;
                $obj->ville = $cityresult->name;

                return response()->json($obj);

            }else{
                $result = ["Erreur" => "Ce pays ne fait pas partie de notre base de donnees"];
                return response()->json($result);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return response()->json(['status' => 'success']);
    }
}
