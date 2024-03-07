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
        $offres = Offre::where('IDUTILISATEUR', $id)->orwhere('IDUTILISATEUR_1', $id)->get();

        return View('private.messagerie', ['offres' => $offres]);
    }
    public function getListMessage(Request $request)
    {
        try {
            $idService = $request->input('idService');
            $idUtilisateur = $request->input('idUtilisateur');
            $id = Auth::user()->IDUTILISATEUR; // Utilisez Auth::id() pour récupérer directement l'ID de l'utilisateur connecté

            $other = Etudiant::findOrFail($idUtilisateur); // Assurez-vous d'importer la classe Utilisateur en haut du fichier
            $him = Etudiant::findOrFail($id);


            // Exécutez la requête en ajoutant ->get()
            $messages = Message::where('IDUTILISATEUR', $id)
                ->where('IDSERVICE', $idService)
                ->where('IDUTILISATEUR_1', $idUtilisateur)
                ->get();


            // Ajoutez les informations de l'étudiant aux messages
            foreach ($messages as $message) {
                $message->otherStudent = $other; // Vous pouvez changer "etudiant" par le nom de la relation appropriée
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
