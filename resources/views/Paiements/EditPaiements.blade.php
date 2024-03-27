@extends('navbar')
@section('content')
    <div style="padding-top: 20px;">
        <div class="card container col-md-6" style="background-color: lightslategray">
            <div class="card-header text-center text-uppercase text-light">Formulaire d'ajout d'un utilisateur</div>
            <div class="card-body">
                <form method="post" action="{{route('Paiements.update', $paiement->id)}}" id="confirm{{$paiement->id}}">
                    @csrf
                    @method('put')
                    <div class="mb-1">
                        <label for="carte" class="form-label text-light">Numéro d'identité</label>
                        <input type="number" class="form-control" id="carte" name="carte" value="{{$paiement->user->cni}}">
                        @error('carte')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="montant" class="form-label text-light">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" value="{{$paiement->montant}}">
                        @error('montant')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="mois" class="form-label text-light">Mois</label>
                        <input type="text" class="form-control" id="mois" name="mois" value="{{$paiement->mois}}">
                        @error('mois')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="an" class="form-label text-light">Année</label>
                        <input type="text" class="form-control" id="an" name="an" value="{{$paiement->annee}}">
                        @error('an')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="nbheure" class="form-label text-light">Nombre d'heure travaillé</label>
                        <input type="number" class="form-control" id="nbheure"  name="nbheure" value="{{$paiement->nbheure_travaille}}">
                        @error('nbheure')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" onclick="return confirmUpdate({{$paiement->id}})">Modifier</button>
                        <button type="reset" class="btn btn-danger">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        function confirmUpdate() {
            return confirm("Êtes-vous sûr de vouloir modifier cette avance ?");
        }

    </script>
@endsection
