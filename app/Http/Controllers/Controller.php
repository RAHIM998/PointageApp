<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    //Fonction de vérification du rôle de l'utilisateur dans l'entreprise
    public function IsAdmin()
    {
        $userConnect = auth()->user();
        return $userConnect->isAdmin();
    }
}
