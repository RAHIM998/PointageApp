@extends('navbar')
@section('content')
    <div class="card mt-3">
        <h2 class="card-header text-center">Liste des employés</h2>
        <div class="card-body">
            <form action="{{ route('User.create') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Email</th>
                    <th scope="col">QRCODE</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($user as $u)
                    <tr>
                        <td>{{$u->prenom}}</td>
                        <td>{{$u->nom}}</td>
                        <td>{{$u->telephone}}</td>
                        <td>{{$u->email}}</td>
                        <td>
                            {!! DNS2D::getBarcodeHTML("$u->qrcode", 'QRCODE', 4, 4) !!}
                        </td>
                        <td>
                            <form method="post" action="{{route('User.destroy', $u->id)}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                            <a href="{{route('User.edit', $u->id)}}" class="btn btn-outline-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="{{route('User.show', $u->id)}}" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-circle-info"></i></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
