<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\EchangeCompetence;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FormulaireController extends Controller
{
    public function index(){
        return View('formulaire.ajoutAnnonces');
    }

    public function indexPortail(int $IDSERVICE, int $IDUTILISATEUR){
        $serviceAdd = Service::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->first();
        $lastService = Service::orderBy('IDSERVICE','desc')->first();
        if($serviceAdd == $lastService){
            return View('formulaire.redirectionForm',['service'=>$lastService]);
        }
        else{
            return redirect()->route('public.index');
        }
    }

    public function store(Request $request){
        if (Auth::check()) {
            $data = $request->only(['demande', 'libelle', 'description', 'prix','dateDebut', 'numero', 'rue', 'codePostal', 'ville']);
            $lastService = Service::orderBy('IDSERVICE', 'desc')->first();
            
            $userId = Auth::user()->IDUTILISATEUR;
            $nextServiceId = $lastService ? $lastService->IDSERVICE + 1 : 1;

            $service = new Service();
            $service->IDUTILISATEUR = $userId;
            $service->IDSERVICE = $nextServiceId;
            $service->LIBELLE = $data['libelle'];
            $service->DESCRIPTION = $data['description'];
            $service->COUT = $data['prix'];
            $service->NUMERO = $data['numero'];
            $service->RUE = $data['rue'];
            $service->CODEPOSTAL = $data['codePostal'];
            $service->VILLE = $data['ville'];
            $service->ESTDEMANDE = $data['demande'];
            $service->DATEPOSTER = $data['dateDebut'];
            $service->ETAT = 1;
            $service->save();
                
            return redirect()->route('formulaire.portail', [$service->IDSERVICE,$service->IDUTILISATEUR]);
        } else {
            // Gérer le cas où l'utilisateur n'est pas authentifié
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour effectuer cette action.');
        }
    }

    public function indexCompetence(int $IDSERVICE, int $IDUTILISATEUR){
        $serviceAdd = Service::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->first();
        $lastService = Service::orderBy('IDSERVICE','desc')->first();
        if($serviceAdd == $lastService){
            return View('formulaire.formulaireEchangeCompetence',['service'=>$lastService]);
        }
        else{
            return redirect()->route('public.index');
        }
    }

    public function storeCompetence(Request $request,int $IDSERVICE, int $IDUTILISATEUR){
        if(Auth::check()){
            $data = $request->only('nomCompetence');
            $serviceAdd = Service::where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->firstOrFail();
            DB::table('service')->where('IDSERVICE',$IDSERVICE)->where('IDUTILISATEUR',$IDUTILISATEUR)->delete();
            $service = new Service();
            $service->IDUTILISATEUR = $serviceAdd->IDUTILISATEUR;
            $service->IDSERVICE = $serviceAdd->IDSERVICE;
            $service->LIBELLE = $serviceAdd->LIBELLE;
            $service->TYPE = 'Echanges_competences';
            $service->DESCRIPTION = $serviceAdd->DESCRIPTION;
            $service->COUT = $serviceAdd->COUT;
            $service->NUMERO = $serviceAdd->NUMERO;
            $service->RUE = $serviceAdd->RUE;
            $service->CODEPOSTAL = $serviceAdd->CODEPOSTAL;
            $service->VILLE = $serviceAdd->VILLE;
            $service->ESTDEMANDE = $serviceAdd->ESTDEMANDE;
            $service->DATEPOSTER = $serviceAdd->DATEPOSTER;
            $service->ETAT = 1;
            $service->save();

            $echangeCompetence = new EchangeCompetence();
            $echangeCompetence->COMPETENCE = $data['nomCompetence'];
            $echangeCompetence->IDSERVICE = $IDSERVICE;
            $echangeCompetence->IDUTILISATEUR = $IDUTILISATEUR;
            $echangeCompetence->save();

            return redirect()->route('service.detail', [$IDSERVICE,$IDUTILISATEUR]);

        }
    }











}
