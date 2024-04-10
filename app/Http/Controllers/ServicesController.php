<?php

namespace App\Http\Controllers;

use DateTime;
use Throwable;
use App\Models\Offre;
use App\Models\Message;
use App\Models\Service;
use App\Models\Covoiturage;
use Illuminate\Http\Request;
use App\Models\EchangeCompetence;
use App\Models\Etudiant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::where('ETAT', 1);
        //dd($services->links());
        $serviceJson = $services->get()->toJson();
        return View('annonce.listeAnnonces', ['services' => $services->paginate(3), 'servicesJson' => $serviceJson]);
    }

    public function suppression(int $IDSERVICE, int $IDUTILISATEUR)
    {
        if ($IDUTILISATEUR == Auth::user()->IDUTILISATEUR) {
            $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR);
            $service->delete();
            return redirect()->route('dashboard')->with('success', "L'annonce a bien été supprimée ! ");
        } else {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez pas supprimer cette annonce !');
        }
    }

    public function filtreDemande(Request $request)
    {
        $data = $request->only(['demande', 'typeService']);
        $services = Service::where('ETAT', 1);

        if ($data['demande'] !== "") {
            $services = Service::where('estDemande', $data['demande']);
        }
        $nomType =  strtoupper($data['typeService']);

        if ($data['typeService'] !== "Tous les types sont sélectionnés" && $data['demande'] !== "Les deux sont sélectionnés") {
            $services = Service::where('TYPE', $nomType)->where('estDemande', $data['demande']);
        } else {
            if ($data['demande'] === "Les deux sont sélectionnés" && $data['typeService'] !== "Tous les types sont sélectionnés") {
                if ($nomType == "ECHANGES_COMPETENCES") {
                    $services = Service::where('TYPE', $nomType);
                } else {
                    $services = Service::where('TYPE', $nomType);
                }
            }
        }

        $serviceJson = $services->get()->toJson();

        return View('annonce.listeAnnonces', ['services' => $services->paginate(3), 'demande' => $data['demande'], 'servicesJson' => $serviceJson]);
    }

    public function detail(int $IDSERVICE, int $IDUTILISATEUR)
    {
        $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR)->first();
        $offreExiste = false;
        $offre = Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->where('IDUTILISATEUR', Auth::user()->IDUTILISATEUR)->first();
        $offreAccepter = false;
        $offreAccept =  Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->where('IDUTILISATEUR', Auth::user()->IDUTILISATEUR)->where('PRIX', $service->COUT)->first();
        if ($offre !== null) {
            $offreExiste = true;
        } else {
            if ($IDUTILISATEUR == Auth::user()->IDUTILISATEUR) {
                $offreExiste = true;
            }
        }

        if ($offreAccept !== null) {
            $offreAccepter = true;
        } else {
            if ($IDUTILISATEUR == Auth::user()->IDUTILISATEUR) {
                $offreAccepter = true;
            }
        }


        return View('annonce.detail', ['service' => $service, 'offreExiste' => $offreExiste, 'offreAccepter' => $offreAccepter]);
    }

    public function offre(Request $request, int $IDSERVICE, int $IDUTILISATEUR)
    {
        $data = $request->only(['prix']);
        $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR)->first();
        if ($service->COUT !== $data['prix']) {
            $offre = Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->where('IDUTILISATEUR', Auth::user()->IDUTILISATEUR)->first();
            $contenu = "Bonjour, je souhaiterai faire une offre à " . $data['prix'] . " crédits (ce message a été envoyé automatiquement) ";
            if ($offre == null) {

                try {
                    Offre::create([
                        'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
                        'IDUTILISATEUR_1' => $IDUTILISATEUR,
                        'IDSERVICE' => $IDSERVICE,
                        'PRIX' => $data['prix']
                    ]);
                    Message::Create([
                        'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
                        'IDUTILISATEUR_2' => $IDUTILISATEUR,
                        'IDSERVICE' => $IDSERVICE,
                        'IDUTILISATEUR_1' => $IDUTILISATEUR,
                        'CONTENU' => $contenu,
                        'DATEMSG' => new DateTime()
                    ]);
                    return redirect()->back()->with('success', "L'offre a bien été validée");
                } catch (Throwable $e) {

                    return redirect()->back()->with('error', 'Les crédits sont insufisants');
                }
            }
        }
        return redirect()->back();
    }

    public function accepter(int $IDSERVICE, int $IDUTILISATEUR)
    {
        $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR)->first();
        $offre = Offre::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR_1', $IDUTILISATEUR)->where('IDUTILISATEUR', Auth::user()->IDUTILISATEUR)->first();
        $contenu = "Bonjour, je tiens à vous informer que j'ai approuvé l'annonce intitulée " . $service->TITIRE . ". Cette notification est générée automatiquement";
        if ($offre == null) {
            try {
                Offre::create([
                    'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
                    'IDUTILISATEUR_1' => $IDUTILISATEUR,
                    'IDSERVICE' => $IDSERVICE,
                    'PRIX' => $service->COUT
                ]);
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Les crédits sont insufisants');
            }
        } else {
            Offre::where('IDUTILISATEUR', $offre->IDUTILISATEUR)
                ->where('IDSERVICE', $offre->IDSERVICE)
                ->update(['PRIX' => $service->COUT]);
            $service = Service::where('IDSERVICE', $IDSERVICE)->where('IDUTILISATEUR', $IDUTILISATEUR);
            $service->update(['ETAT'=>2]);
        }

        Message::Create([
            'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
            'IDUTILISATEUR_2' => $IDUTILISATEUR,
            'IDSERVICE' => $IDSERVICE,
            'IDUTILISATEUR_1' => $IDUTILISATEUR,
            'CONTENU' => $contenu,
            'DATEMSG' => new DateTime()
        ]);

        return redirect()->back()->with('success', "L'annonce a bien été acceptée ! ");
    }
}
