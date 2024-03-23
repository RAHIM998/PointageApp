@extends('navbar')
@section('content')
    <div class="container text-center mt-4">
        <h1>Details de l'employé</h1>
    </div>
    <ul class="list-group container mt-4" style="max-width: 400px;">
        <li class="list-group-item"><span style="font-weight: bold">Id : </span>{{$user->id}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Prénom : </span>{{$user->prenom}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Nom : </span>{{$user->nom}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Téléphone : </span>{{$user->telephone}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Email : </span>{{$user->email}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Numéro de carte d'identité : </span>{{$user->cni}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Nombre d'heure de travail : </span>{{$user->horaires}} heures</li>
        <li class="list-group-item">{!! DNS2D::getBarcodeHTML("$user->qrcode", 'QRCODE', 4, 4) !!}</li>
        <li class="list-group-item"><span style="font-weight: bold">Coût journalier moyenne : </span>{{$user->cjm}} CFA</li>
        <li class="list-group-item"><span style="font-weight: bold">Salaire mensuel : </span> {{$user->salaire}} CFA</li>
        <li class="list-group-item"><span style="font-weight: bold">Rôle de l'employé : </span>{{$user->role}}</li>
    </ul><br><br>
@endsection


