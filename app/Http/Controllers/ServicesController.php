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
        $services = Service::where('ETAT', 1)->get();
        $serviceJson = $services->toJson();
        return View('annonce.listeAnnonces', ['services' => $services, 'servicesJson' => $serviceJson]);
    }

    public function filtreDemande(Request $request)
    {
        $data = $request->only(['demande', 'typeService']);
        $services = Service::where('ETAT', 1)->get();
        if ($data['demande'] !== "") {
            $services = Service::where('estDemande', $data['demande'])->get();
        }
        $nomType =  strtoupper($data['typeService']);

        if ($data['typeService'] !== "Tous les types sont sélectionnés" && $data['demande'] !== "Les deux sont sélectionnés") {
            $services = Service::where('TYPE', $nomType)->where('estDemande', $data['demande'])->get();
        } else {
            if ($data['demande'] === "Les deux sont sélectionnés" && $data['typeService'] !== "Tous les types sont sélectionnés") {
                if($nomType == "ECHANGES_COMPETENCES"){
                    $services = Service::where('TYPE',$nomType)->get();
                }
                else{
                    $services = Service::where('TYPE', $nomType)->get();
                }
                
            }
        }
        $serviceJson = $services->toJson();

        return View('annonce.listeAnnonces', ['services' => $services, 'demande' => $data['demande'], 'servicesJson' => $serviceJson]);
    }

    public function detail(int $IDSERVICE, int $IDUTILISATEUR)
    {
        $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR)->first();
        $offreExiste = false;
        $offre = Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->first();
        if ($offre !== null) {
            $offreExiste = true;
        }
        return View('annonce.detail', ['service' => $service, 'offreExiste' => $offreExiste]);
    }

    public function offre(Request $request, int $IDSERVICE, int $IDUTILISATEUR)
    {
        $data = $request->only(['prix']);
        $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR)->first();
        if ($service->COUT !== $data['prix']) {
            $offre = Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->where('IDUTILISATEUR', Auth::user()->IDUTILISATEUR)->first();
            if ($offre == null) {
                Offre::create([
                    'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
                    'IDUTILISATEUR_1' => $IDUTILISATEUR,
                    'IDSERVICE' => $IDSERVICE,
                    'PRIX' => $data['prix']
                ]);
            }
        }
        return redirect()->back();
    }
}
