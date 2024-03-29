<?php

namespace App\Http\Controllers;

use App\Models\Avance;
use App\Models\Paiement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\Exception;

class AvanceController extends Controller
{
    //Fonction d'affichage
    public function index()
    {
        $avance = Avance::with('user')->get();
        return view('Paiements.ListeAvances', ['avance' => $avance]);
    }

    //Fonction d'appel du formulaire d'ajout
    public function create()
    {
        $avance = null;
        return view('Paiements.AjoutAvance', ['avance' => $avance]);
    }

    //Fonction de sauvegarde
    public function store(Request $request)
    {
        $cni = $request->input('carte');
        $user = User::where('cni', $cni)->first();

        if ($user) {

            if ($request->input('montant') <= $user->salaire/2){
                $avance = new Avance([
                    'user_id' => $user->id,
                    'date' => Carbon::now()->toDateString(),
                    'montant' => $request->montant,
                ]);

                $avance->save();

                return redirect()->route('Avance.index')->with('success', 'Avance enregistrée avec succès !');
            }else{
                return redirect()->route('Avance.index')->with('error', 'Cet employé n\'a pas le droit de prendre une avance superrieur à la moitié son salaire !');
            }

        } else {
            return redirect()->route('Avance.index')->with('error', 'Cet employé n\'existe pas !');
        }
    }

    //Fonction d'appel du formulaire de modification
    public function edit(string $id)
    {
        try {
            $avance = Avance::with('user')->find($id);
            if (!$avance){
                return redirect()->route('Avance.index')->with('error', 'Cet avance n\'existe pas');
            }
            return view('Paiements.AjoutAvance', compact('avance'));
        }catch (Exception $exception){
            $exception->getMessage();
        }
    }

    //Fonction de modification
    public function update(Request $request, string $id)
    {
        $AvanceEdit = Avance::with('user')->find($id);

        if ($AvanceEdit && $AvanceEdit->user) {
            $AvanceEdit->update([
                'user_id' => $AvanceEdit->user->id,
                'date' => Carbon::now()->toDateString(),
                'montant' => $request->montant
            ]);
            return redirect()->route('Avance.index')->with('success', 'Avance modifié avec succés !');
        }else{
            return redirect()->route('Avance.index')->with('error', 'Employé correspondant à cette carte non trouvé!');
        }
    }

    //Fonction de suppression
    public function destroy(string $id)
    {
        Avance::destroy($id);
        return redirect()->route('Avance.index')->with('success', 'Avance supprimé avec succés !');
    }
}
