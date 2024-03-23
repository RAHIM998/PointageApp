<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <title>Gestion de poibtage</title>
</head>
<body>
<div class="back" style="background-image: url('{{ asset('images/back2.jpg') }}'); background-repeat: no-repeat;">
    <div class="card offset-6 col-md-4 " style="background-color: rgba(169, 169, 169, 0.3);position: absolute; top: 180px;">
        <div class="font-weight-bold card-header text-center text-light" style="font-weight: bold; font-size: 15px" >Connecter vous svp !</div>
        <div class="card-body">
            <form action="{{ route('connect') }}" method="post">
                @csrf
                @error('email')
                <br><div class="alert alert-danger">{{$message}}</div>
                @enderror
                <div class="input-group flex-nowrap mb-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                    <input style="margin-left: 4px" type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror" placeholder="Login" autofocus>

                </div>
                <div class="input-group flex-nowrap mb-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-lock"></i></span>
                    <input style="margin-left: 4px" type="password" id="mdp" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Mot de passe">
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary" type="submit">Se Connecter</button>
                </div>
            </form>
            <br>
        </div>
    </div>

</div>

<script src="https://kit.fontawesome.com/a1e85ba704.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
