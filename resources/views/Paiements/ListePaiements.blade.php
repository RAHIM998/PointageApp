@extends('navbar')
@section('content')
    <div class="card mt-3">
        <h2 class="card-header text-center">Liste des employés déja rémunéré pour ce mois</h2>
        <div class="card-body">
            <form action="{{ route('Avance.index') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Les avances</button>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            </form>
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Heurers travaillées</th>
                    <th scope="col">Montant payé</th>
                    <th scope="col">Date de paiement</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">

                @foreach($paiements as $paie)
                    <tr>
                        @if($paie->user)
                            <td>{{$paie->user->prenom}}</td>
                            <td>{{$paie->user->nom}}</td>
                            <td>{{$paie->user->email}}</td>
                            <td>{{$paie->nbheure_travaille}}</td>
                            <td>{{$paie->montant}}</td>
                            <td>{{$paie->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('Paiements.destroy', $paie->id)}}" id="delete{{$paie->id}}">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirmDelete({{$paie->id}})" class="btn btn-outline-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <a href="{{route('Paiements.edit', $paie->id)}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </td>
                        @else
                            <p class="text-center alert alert-danger">Un utilisateur a été supprimé !</p>
                        @endif

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script>

        function confirmDelete(id) {
            return confirm("Êtes-vous sûr de vouloir supprimer cet élément ?");
        }

    </script>

@endsection
