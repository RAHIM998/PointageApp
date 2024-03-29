<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
Use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class PointageController extends Controller
{
    //Fonction d'affichages de la liste des prensents
    public function index()
    {
        $datejour = $this->DateDays();
        $role = $this->IsAdmin();
        $listePresent = Pointage::with('user')
            ->where('date', $datejour)
            ->get();
        return view('Pointage.PresenceJour', ['presence' => $listePresent, 'role' => $role]);
    }

    //Fonction d'appel du scanner
    public function create()
    {
        $role = $this->IsAdmin();
        return view('Pointage.Scanner', ['role' => $role]);
    }

    //Fonction de sauvegarde des Scanner
    public function store(Request $request)
    {
        // Récupère le code QR envoyé depuis le frontend
        $qrCode = $request->input('qrCode');
        $user = User::where('qrcode', $qrCode)->first();

        if ($user) {
            $dateJour = $this->DateDays();
            // Compte le nombre total de pointages pour l'utilisateur dans la journée
            $nbPointageJournalier = Pointage::where('user_id', $user->id)
                ->whereDate('date', $dateJour)
                ->get();

            if ($nbPointageJournalier->isNotEmpty()) {
                foreach ($nbPointageJournalier as $pointage) {
                    // Vérifie si la propriété heure_sortie est déjà définie
                    if (!is_null($pointage->heure_sortie)) {
                        return response()->json(['success' => true, 'message' => 'Désolé M/Mme ' . $user->nom . ', vous avez déjà effectué votre pointage de sortie']);
                    }
                    // Met à jour la propriété heure_sortie pour cet objet pointage
                    $pointage->heure_sortie = Carbon::now()->toTimeString();
                    $pointage->save();
                }
                return response()->json(['success' => true, 'message' => 'Au revoir M./Mme ' . $user->nom . ' et à bientôt', 'nb' => $nbPointageJournalier]);
            } else {
                // Le nombre total de pointages pour l'utilisateur dans la journée est vide, donc nous devons créer un nouveau pointage
                $pointage = new Pointage([
                    'user_id' => $user->id,
                    'date' => Carbon::now()->toDateString(),
                    'heure_entree' => Carbon::now()->toTimeString(),
                ]);
                $pointage->save();
                return response()->json(['success' => true, 'message' => 'Bienvenue M./Mme ' . $user->nom]);
            }
        } else {
            // L'utilisateur n'a pas été trouvé
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé pour le QR Code fourni.']);
        }
    }


    //Affichage des détails des employé present de la journée
    public function show(string $id)
    {
        try {
            $role = $this->IsAdmin();
            $pointed = Pointage::with('user')->find($id);
            if ($pointed){
                return view('Pointage.ShowUsers', ['pointer' => $pointed, 'role' => $role]);
            } else {
                echo "Désolé cet identifiant n'existe pas !";
            }
        } catch (Exception $exception){
            $exception->getMessage();
        }
    }


    //Suppression
    public function destroy(string $id)
    {
        Pointage::destroy($id);
        return to_route('AffichagePresence')->with('succes', 'Utilisateur supprimé avec succés !');
    }
}
