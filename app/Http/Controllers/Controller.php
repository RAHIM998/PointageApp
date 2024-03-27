<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    //Fonction de détermination de la date du jour
    public function DateDays()
    {
        $now = Carbon::now();
        return $now->toDateString();
    }
}
