<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller
{
    //Méthode d'affichage de la liste des utilisateurs
    public function index()
    {
        $user = User::all();
        return view('Users.ListeUsers', compact('user'));
    }

    //Méthode d'appel du formulaire d'ajout d'utilisateur
    public function create()
    {
        return view('Users.AddUser');
    }

    //Méthode de sauvegarde dans la base de donnée
    public function store(UserRequest $request)
    {
        $validateData = $request->validated();
        $cjm = $request->input('salaire')/30;
        $cni = $request->input('cni');
        if ($this->cniExist($cni)) {
            return redirect()->route('User.index')->with('error', 'Cette carte existe déjà dans la base de données.');
        }
        $validateData['cjm'] = $cjm;
        $validateData['qrcode'] = $cni;
        $validateData['password'] = bcrypt($request->password);
        User::create($validateData);
        return redirect()->route('User.index')->with('success', 'Utilisateur créé avec succès');
    }

    //Méthode de vérification de l'éxistance de la CNI
    public function cniExist($cni){
        return User::where('cni', $cni)->exists();
    }


    //Méthode d'affichage des détailles d'un utilisateur
    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user){
                return redirect()->route('User.index')->with('error', 'Utilisateur non trouvée !');
            }
            return view('Users.DetailsUser', compact('user'));
        }catch (Exception $exception){
            $exception->getMessage();
        }

    }

    //Méthode d'appel du formulaire de modification
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user){
            return redirect()->route('Users.index');
        }
        return view('Users.EditUser', compact('user'));
    }

    //Méthode de mise à jours
    public function update(EditUserRequest $request, string $id)
    {
        $validateData =$request->validated();
        $userEdit = User::find($id);
        if ($userEdit){
            $userEdit -> update($validateData);
            return redirect()->route('User.index')->with('succes', 'Utilisateur modifié avec succés !');
        }
    }

    //Méthode de suppression
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('User.index')->with('succes', 'Utilisateur supprimé avec succés !');
    }
}
