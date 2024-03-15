<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Covoiturage;
use Illuminate\Http\Request;
use App\Models\EchangeCompetence;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::All();
        $serviceJson = $services->toJson();
        return View('annonce.listeAnnonces', ['services' => $services, 'servicesJson' => $serviceJson]);
    }

    public function filtreDemande(Request $request)
    {
        $data = $request->only(['demande', 'typeService']);
        $services = Service::All();
        if ($data['demande'] !== "Choose a type") {
            $services = Service::where('estDemande', $data['demande'])->get();
        }
        $nomType =  strtoupper($data['typeService']);
        if ($data['typeService'] !== "Choose a type" && $data['demande'] !== "Choose a type") {
            switch ($nomType) {
                case "COVOITURAGE":
                    $services = DB::table('service')
                    ->where('estDemande', $data['demande'])
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                              ->from('covoiturage')
                              ->whereColumn('service.IDUTILISATEUR', 'covoiturage.IDUTILISATEUR')
                              ->whereColumn('service.IDSERVICE', 'covoiturage.IDSERVICE');
                    })->get();
                    break;
                case "ECHANGE_COMPETENCE":
                    $services = DB::table('service')
                    ->where('estDemande', $data['demande'])
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                              ->from('echange_competences')
                              ->whereColumn('service.IDUTILISATEUR', 'echange_competences.IDUTILISATEUR')
                              ->whereColumn('service.IDSERVICE', 'echange_competences.IDSERVICE');
                    })
                    ->get();
                    break;

                default:
                    break;
            }
        }
        else{
            if($data['demande'] === "Choose a type" && $data['typeService'] !== "Choose a type"){
                switch ($nomType) {
                    case "COVOITURAGE":
                        $services = DB::table('service')
                        ->whereExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from('covoiturage')
                                ->whereColumn('service.IDUTILISATEUR', 'covoiturage.IDUTILISATEUR')
                                ->whereColumn('service.IDSERVICE', 'covoiturage.IDSERVICE');
                        })->get();
                        break;
                    case "ECHANGE_COMPETENCE":
                        $services = DB::table('service')
                        ->whereExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from('echange_competences')
                                ->whereColumn('service.IDUTILISATEUR', 'echange_competences.IDUTILISATEUR')
                                ->whereColumn('service.IDSERVICE', 'echange_competences.IDSERVICE');
                        })
                        ->get();
                        break;

                    default:
                        break;
                }
            }
    }
        $serviceJson = $services->toJson();

        return View('annonce.listeAnnonces', ['services' => $services, 'demande' => $data['demande'], 'servicesJson' => $serviceJson]);
    }

    public function detail(int $IDSERVICE, int $IDUTILISATEUR){
        $service = Service::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->first();
        $serviceType = $service->covoiturage()->firstOrNull();
        if($serviceType == null){
            $serviceType = $service->echange_competences()->firstOrNull();
        }

        return View('annonce.detail',['service' => $service]);
    }

}
