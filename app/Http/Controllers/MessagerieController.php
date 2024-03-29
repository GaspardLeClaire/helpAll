<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;
use App\Http\Controllers\Controller;
use App\Models\Etudiant;
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
    public function getListMessage(Request $request)
    {
        try {

            // comment m'y prendre ? IDUTILISATEUR = celui qui envoit le message IDUTILISATEUR_1 = à qui IDUTILISATEUR_2 = propriétaire du service

            // Si $idUtilisateur_1 = $id alors la personne auth est l'auteur de l'offre
            // si $idUtilisateur_2 = $id alors la personne auth est l'auteur du service

            $idService = $request->input('idService');
            $idUtilisateur_1 = $request->input('idUtilisateur');
            $idUtilisateur_2 = $request->input('idUtilisateur_1');
            
            $id = Auth::user()->IDUTILISATEUR;

            

           

            $other = Etudiant::findOrFail($idUtilisateur_1); 
            $him = Etudiant::findOrFail($id);


            // Exécutez la requête en ajoutant ->get()
            $messages = Message::where('IDSERVICE', $idService)->where('IDUTILISATEUR_2', $idUtilisateur_2)
                        ->orWhere('IDUTILISATEUR',$id)
                        ->orWhere('IDUTILISATEUR',$idUtilisateur_1)
                        ->orderBy('DATEMSG')
                        ->get();


            // Ajoutez les informations de l'étudiant aux messages
            foreach ($messages as $message) {
                $message->otherStudent = $other; 
                $message->him = $him;
            }


            return response()->json($messages);
        } catch (Throwable $e) {
            dd($e); // Affichez l'exception pour voir ce qui ne va pas
            report($e);
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des messages.'], 500);
        }
    }
}
