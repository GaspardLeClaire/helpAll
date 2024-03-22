<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Service;
use App\Models\Covoiturage;
use Illuminate\Http\Request;
use App\Models\EchangeCompetence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::where('ETAT',1)->get();
        $serviceJson = $services->toJson();
        return View('annonce.listeAnnonces', ['services' => $services, 'servicesJson' => $serviceJson]);
    }

    public function filtreDemande(Request $request)
    {
        $data = $request->only(['demande', 'typeService']);
        $services = Service::where('ETAT',1)->get();
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
        $v = $service->echange_competence()->first()->COMPETENCE;
        //dd($v);
        return View('annonce.detail',['service' => $service]);
    }

    public function offre(Request $request,int $IDSERVICE, int $IDUTILISATEUR){
        $data = $request->only(['prix']);
        $service = Service::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->first();
        if($service->COUT !== $data['prix']){
            $offre = Offre::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR);
            if(!$offre){
                Offre::create([
                    'IDUTILISATEUR'=> Auth::user()->IDUTILISATEUR,
                    'IDUTILISATEUR_1'=>$IDUTILISATEUR,
                    'IDSERVICE'=> $IDSERVICE,
                    'PRIX'=> $data['prix']
                ]);
            }
           
            
        }
        return redirect()->back();
    }

}
