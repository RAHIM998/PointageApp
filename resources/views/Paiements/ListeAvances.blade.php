@extends('navbar')
@section('content')
    <div class="card mt-3">
        <h2 class="card-header text-center">Liste des avances</h2>
        <div class="card-body">
            <form action="{{ route('Avance.create') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Ajouter une avance</button>
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
                    <th scope="col">Téléphone</th>
                    <th scope="col">Montant avancé</th>
                    <th scope="col">Date de l'avance</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">

                @forelse($avance as $avanceItem)
                    <tr>
                        @if($avanceItem->user)
                            <td>{{ $avanceItem->user->prenom }}</td>
                            <td>{{ $avanceItem->user->nom }}</td>
                            <td>{{ $avanceItem->user->telephone }}</td>
                            <td>{{ $avanceItem->montant }}</td>
                            <td>{{ $avanceItem->date }}</td>
                            <td>
                                <form method="post" action="{{route('Avance.destroy', $avanceItem->id)}}" id="delete{{$avanceItem->id}}">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirmDelete({{$avanceItem->id}})" class="btn btn-outline-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <a href="{{route('Avance.edit', $avanceItem->id)}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </td>
                        @else
                            <p class="text-center alert alert-danger">Un utilisateur a été supprimé !</p>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune avance n'a été enregistrée.</td>
                    </tr>
                @endforelse

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
