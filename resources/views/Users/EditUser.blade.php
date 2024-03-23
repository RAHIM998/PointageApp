@extends('navbar')
@section('content')
    <div style="padding-top: 20px;">
        <div class="card container col-md-6" style="background-color: lightslategray">
            <div class="card-header text-center text-uppercase text-light">Formulaire d'ajout d'un utilisateur</div>
            <div class="card-body">
                <form method="post" action="{{route('User.update', $user->id)}}" >
                    @csrf
                    @method('put')
                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{$user->nom}}">
                        @error('nom')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{$user->prenom}}">
                        @error('prenom')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Carte national d'identité</label>
                        <input type="number" class="form-control" id="cni" name="cni" value="{{$user->cni}}">
                        @error('cni')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                        @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Horaire</label>
                        <input type="number" class="form-control" id="horaires"  name="horaires" value="{{$user->horaires}}">
                        @error('horaires')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Salaire</label>
                        <input type="number" class="form-control" id="salaire"  name="salaire" value="{{$user->salaire}}">
                        @error('salaire')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light" for="inputGroupSelect01">Rôles de l'utilisateur</label>
                        <select style="margin-left: 3px;" class="form-control" @error('role') is-invalid @enderror" id="role" name="role" value="{{ old('role') }}">
                        <option selected value="{{$user->role}}">{{$user->role}}</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Employé</option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{$user->telephone}}">
                        @error('telephone')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="nom" class="form-label text-light">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{$user->password}}">
                        @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        <button type="reset" class="btn btn-danger">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
