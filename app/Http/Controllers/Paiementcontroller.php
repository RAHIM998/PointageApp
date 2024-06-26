<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use App\Models\Avance;
use App\Models\Pointage;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\Exception;

class Paiementcontroller extends Controller
{
    //Lister les paiements
    public function index()
    {
        $mois = Carbon::now()->month;
        $paiements = Paiement::with('user')->whereMonth('created_at', $mois)->get();
        return view('Paiements.ListePaiements', ['paiements' => $paiements]);

    }

    //Génération de la fiche de paie
    public function store(Request $request, string $id)
    {
        $users = User::find($id);
        $mois = now()->format('m');
        $annee = now()->format('Y');

        $paiementExist = Paiement::where('user_id', $users->id)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->exists();

        $avances = Avance::where('user_id', $users->id)
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->sum('montant');

        if ($users && !$paiementExist){
            $totalHeuresTravaille = 0;
            $pointages = Pointage::where('user_id', $users->id)
                ->whereMonth('date', $mois)
                ->whereYear('date', $annee)
                ->get();
            foreach ($pointages as $pointage) {
                $nbSecondes = Carbon::parse($pointage->heure_sortie)->diffInSeconds(Carbon::parse($pointage->heure_entree));
                $nbHeures = $nbSecondes / 3600;
                $totalHeuresTravaille += round($nbHeures, 2);
            }

            $salaireBrut = $users->cjm * $totalHeuresTravaille;

            if ($avances){
                $paie = new Paiement([
                    'user_id' => $users->id,
                    'montant' => $salaireBrut - $avances,
                    'mois' => $mois,
                    'annee' => $annee,
                    'nbheure_travaille' => $totalHeuresTravaille
                ]);
                $paie->save();

                return redirect()->route('BulletinPaie', ['id' =>$id])->with('success', 'Bulletin générer avec succès !');
            }else{
                Paiement::create([
                    'user_id' => $users->id,
                    'montant' => $salaireBrut,
                    'mois' => $mois,
                    'annee' => $annee,
                    'nbheure_travaille' => $totalHeuresTravaille
                ]);

                return redirect()->route('BulletinPaie',  ['id' =>$id])->with('success', 'Bulletin générer avec succès !');
            }
        }else{
            return redirect()->route('User.index')->with('error', 'Désolé cet employé n\'existe pas ou a déjà été payé !');
        }

    }


    //Formulaire de modification
    public function edit(string $id)
    {
        try {
            $paiement = Paiement::with('user')->find($id);
            if (!$paiement){
                return redirect()->route('Paiement.index')->with('error', 'Ce paiement n\'existe pas');
            }
            return view('Paiements.EditPaiements', compact('paiement'));
        }catch (Exception $exception){
            $exception->getMessage();
        }
    }

    //Mise à jour
    public function update(Request $request, string $id)
    {
        $PaiementEdit = Paiement::with('user')->find($id);

        if ($PaiementEdit && $PaiementEdit->user) {
            $PaiementEdit->update([
                'user_id' => $PaiementEdit->user->id,
                'montant' => $request->montant,
                'mois'=> $request->mois,
                'annee' => $request->an,
                'nbheure_travaille' => $request->nbheure,
            ]);
            return redirect()->route('Paiements.index')->with('success', 'Paiement modifié avec succés !');
        }else{
            return redirect()->route('Avance.index')->with('error', 'Employé correspondant à cette carte non trouvé!');
        }
    }

    //Suppression
    public function destroy(string $id)
    {
        Paiement::destroy($id);
        return redirect()->route('Paiements.index')->with('success', 'Paiements suprimé avec succès !');
    }

    //Fonction de génération du bulletin de paie
    public function generateBulletin(string $id)
    {
        $moisActuel = now()->format('m');
        $anneeActuelle = now()->format('Y');
        $paiements = Paiement::with('user')
            ->where('user_id', $id)
            ->whereMonth('created_at', $moisActuel)
            ->whereYear('created_at', $anneeActuelle)
            ->get();
        $avances = Avance::where('user_id', $id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        $invoiceId = $paiements->first()->id;
        $orderId = $paiements->first()->user->cni;
        $orderDate = now()->format('d-m-Y');

        $pdf = PDF::loadView('Paiements.BulletinPaie', [
            'paie' => $paiements,
            'avance' => $avances,
            'invoiceId' => $invoiceId,
            'orderId' => $orderId,
            'orderDate' => $orderDate,
        ]);

        return $pdf->stream('BulletinPaie.pdf');
    }

}
