<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Offre;
use App\Models\Message;
use App\Models\Service;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    public function index()
    {

        $id = Auth::user()->IDUTILISATEUR;
        $offres = new Offre();
        $offres = Offre::where('IDUTILISATEUR', $id)->orWhere('IDUTILISATEUR_1', $id)->get();
        return View('messages.messagerie', ['offres' => $offres]);
    }
    public function store(Request $request, int $IDUTILISATEUR_2, int $IDSERVICE, int $IDUTILISATEUR_1){
        $data = $request->only(["CONTENU"]);
        Message::create([
            'IDUTILISATEUR' => Auth::user()->IDUTILISATEUR,
            'IDUTILISATEUR_2'=>$IDUTILISATEUR_2,
            'IDSERVICE'=> $IDSERVICE,
            'CONTENU' => $data['CONTENU'],
            'DATEMSG'=> new DateTime(),
            'IDUTILISATEUR_1'=>$IDUTILISATEUR_1
        ]);
        return redirect()->back();
    }
}
