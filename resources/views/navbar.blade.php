
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de pointage</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Gestion de pointage</span>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('User.index')}}">
                            Liste des employé
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('Pointage')}}">
                            Scanner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('AffichagePresence')}}">
                            Présence du jour
                        </a>
                    </li>
                    <!-- Ajoute d'autres liens selon tes besoins -->
                </ul>
            </div>
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="nav-link" style="margin-left: 15px;">Se déconnecter </button>
                        </form>
                    </li>
                </ul>
            @endauth
        </nav>
        <!-- Contenu principal -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap JS et dépendances -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a1e85ba704.js" crossorigin="anonymous"></script>
</body>
</html>
