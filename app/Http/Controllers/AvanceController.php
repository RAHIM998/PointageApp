<?php

namespace App\Http\Controllers;

use App\Models\Avance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\Exception;

class AvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avance = Avance::with('user')->get();
        return view('Paiements.ListeAvances', ['avance' => $avance]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $avance = null;
        return view('Paiements.AjoutAvance', ['avance' => $avance]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $avanceEdit = Avance::find($id);
        $cni = $request->input('carte');
        $user = User::where('cni', $cni)->first();
        if ($avanceEdit && $user) {
            $avanceEdit->update([
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'montant' => $request->montant
            ]);
            return redirect()->route('Avance.index')->with('success', 'Avance modifié avec succés !');
        }else{
            return redirect()->route('Avance.index')->with('error', 'Employé correspondant à cette carte non trouvé!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Avance::destroy($id);
        return redirect()->route('Avance.index')->with('success', 'Avance supprimé avec succés !');
    }
}
