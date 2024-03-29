@extends($role ? 'navbar' : 'Pointage.navbar')
@section('content')
    <div class="container text-center mt-4">
        <h1>Details de l'employé</h1>
    </div>
    <ul class="list-group container mt-4" style="max-width: 400px;">
        <li class="list-group-item"><span style="font-weight: bold">Identifiant : </span>{{$pointer->id}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Prénom : </span>{{$pointer->user->prenom}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Nom : </span>{{$pointer->user->nom}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Téléphone : </span>{{$pointer->user->telephone}}</li>
        <li class="list-group-item"><span style="font-weight: bold">Heure d'arrivé : </span>{{$pointer->heure_entree}}</li>
        @if($pointer->heure_sortie)
            <li class="list-group-item"><span style="font-weight: bold">Heure de départ : </span>{{$pointer->heure_sortie}}</li>
            @else
            <li class="list-group-item"><span style="font-weight: bold">Heure de départ : </span> Encore présent dans l'entreprise</li>
        @endif
        <li class="list-group-item"><span style="font-weight: bold">Email : </span>{{$pointer->user->email}}</li>
        <li class="list-group-item">{!! DNS2D::getBarcodeHTML("$pointer->user->qrcode", 'QRCODE', 4, 4) !!}</li>
        @if($role)
            <li class="list-group-item"><span style="font-weight: bold">Nombre d'heure de travail : </span>{{$pointer->user->horaires}} heures</li>
            <li class="list-group-item"><span style="font-weight: bold">Numéro de carte d'identité : </span>{{$pointer->user->cni}}</li>
            <li class="list-group-item"><span style="font-weight: bold">Salaire mensuel : </span> {{$pointer->user->salaire}}CFA</li>
            <li class="list-group-item"><span style="font-weight: bold">Coût journalier moyenne : </span>{{$pointer->user->cjm}} CFA</li>
            <li class="list-group-item"><span style="font-weight: bold">Rôle de l'employé : </span>{{$pointer->user->role}}</li>
        @endif
    </ul><br><br>
@endsection


