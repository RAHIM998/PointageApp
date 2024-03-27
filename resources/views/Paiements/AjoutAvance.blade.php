@extends('navbar')
@section('content')
        <div class="card container col-md-6 mt-5" style="background-color: lightslategray">
            <div class="card-header text-center text-uppercase text-light">Formulaire {{ $avance ? 'de modification' : 'd\'ajout' }} d'une avance</div>
            <div class="card-body">
                <form method="post" action="{{ $avance ? route('Avance.update', $avance->id) : route('Avance.store') }}" onsubmit="{{ $avance ? 'return confirmUpdate()' : 'return confirmSave()' }}">
                    @csrf
                    @if($avance)
                        @method('put')
                    @endif
                    <div class="mb-1">
                        <label for="carte" class="form-label text-light">Carte d'identité</label>
                        <input type="number" class="form-control" id="carte" name="carte" value="{{ $avance && $avance->user ? $avance->user->cni : '' }}">
                        @error('carte')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="montant" class="form-label text-light">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" value="{{ $avance ? $avance->montant : '' }}">
                        @error('montant')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">{{ $avance ? 'Modifier' : 'Ajouter' }}</button>
                        <button type="reset" class="btn btn-danger">Annuler</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function confirmUpdate() {
                return confirm("Êtes-vous sûr de vouloir modifier cette avance ?");
            }

            function confirmSave() {
                return confirm("Êtes-vous sûr de vouloir ajouter cette avance ?");
            }
        </script>
@endsection
