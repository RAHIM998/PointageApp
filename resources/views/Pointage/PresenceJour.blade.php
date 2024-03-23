@extends($role ? 'navbar' : 'Pointage.navbar')
@section('content')

    <div class="card mt-3">
        <h2 class="card-header alert alert-success text-center">
            @if ($presence)
                Liste des employés présents du jour
            @else
                Aucun employé n'est présent pour le moment.
            @endif
        </h2>
        <div class="card-body">
            <table class="table table-striped container">

                <thead>


                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Heure d'arrivée</th>
                    <th scope="col">Heure de départ</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>

                <tbody class="table-group-divider">
                @foreach($presence as $pr)
                    <tr>
                        <td>{{$pr['prenom']}}</td>
                        <td>{{$pr['nom']}}</td>
                        <td>{{$pr['heure_entree']}}</td>
                        <td>{{$pr['heure_sortie'] ? : 'Encore présent dans l\'entreprise'}}</td>

                        <td>
                            <div class="d-inline">
                                @if($role)
                                    <form method="post" action="{{route('Suppresion', $pr['id'])}}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                @endif
                                <a href="{{route('Details', $pr['id'])}}" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-circle-info"></i></a>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
