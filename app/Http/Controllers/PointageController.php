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
        $listePresent = Pointage::where('date', $datejour)->get();
        $role = $this->IsAdmin();
        $listePresentUser = [];

        foreach ($listePresent as $PointageExist){
            $user = User::find($PointageExist->user_id);
            $id = $PointageExist->id;
            $heureEntree = $PointageExist->heure_entree;
            $heureSortie = $PointageExist->heure_sortie;

            $listePresentUser[]= [
                'nom' => $user ? $user->nom : 'Aucun utilisateur trouvé !',
                'prenom' => $user ? $user->prenom : 'Aucun utilisateur trouvé !',
                'id' =>$id,
                'heure_entree' => $heureEntree,
                'heure_sortie' => $heureSortie,
            ];
        }

        return view('Pointage.PresenceJour', ['presence' => $listePresentUser, 'role' => $role]);
    }

    //Fonction d'appel du scanner
    public function create()
    {
        $role = $this->IsAdmin();
        return view('Pointage.Scanner', ['role' => $role]);
    }

    //Fonction de sauvegarde des Scanner
    public function post(Request $request)
    {
        // Récupère le code QR envoyé depuis le frontend
        $qrCode = $request->input('qrCode');
        $user = User::where('qrcode', $qrCode)->first();

        if ($user) {
            $dateJour = $this->DateDays();
            // Compte le nombre total de pointages pour l'utilisateur dans la journée
            $nbPointageJournalier = Pointage::where('user_id', $user->id)
                ->whereDate('date', $dateJour)
                ->count();

            switch ($nbPointageJournalier) {
                case 0:
                    // Crée un nouvel enregistrement de pointage avec l'heure d'entrée actuelle
                    $pointage = new Pointage([
                        'user_id' => $user->id,
                        'date' => Carbon::now()->toDateString(),
                        'heure_entree' =>  Carbon::now()->toTimeString(),
                    ]);
                    $pointage->save();
                    return response()->json(['success' => true, 'message' => 'Bienvenue M./Mme ' . $user->nom]);
                    break;
                case 1:
                    // Met à jour l'enregistrement de pointage existant avec l'heure de sortie actuelle
                    $existPointage = Pointage::where('user_id', $user->id)
                        ->whereDate('date', $dateJour)
                        ->first();
                    $existPointage->update([
                        'heure_sortie' => Carbon::now()->toTimeString()
                    ]);
                    return response()->json(['success' => true, 'message' => 'Au revoir M./Mme ' . $user->nom . ' et à bientôt']);
                    break;
                default:
                    // L'utilisateur a déjà pointé deux fois aujourd'hui
                    return response()->json(['success' => false, 'message' => 'Désolé M/Mme'.$user->nom.', vous avez déjà effectué votre pointage de sortie']);
                    break;
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
            $pointed = Pointage::find($id);
            if ($pointed){
                $user = User::find($pointed->user_id);
                return view('Pointage.ShowUsers', ['pointer' =>$pointed, 'emp' => $user, 'role' =>$role]);
            }else{
                echo "Désolé cet identifiant n'existe pas !";
            }
        }catch (Exception $exception){
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
