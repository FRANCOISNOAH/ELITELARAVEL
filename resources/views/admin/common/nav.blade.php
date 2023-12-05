<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-headset"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        <span class="dropdown-header">
                          NOM DE L'ENTREPRISE
                        </span>

                <span class="dropdown-header">NON DU CONNECTER</span>

                <div class="dropdown-divider"></div>
                <span class="dropdown-header">role du connecter</span>

                <span class="dropdown-header">
                           non de l'admin pour les noms admin
                        </span>
                <div class="dropdown-divider"></div>
                <form method="post" action="{{route("logout")}}" id="logout">
                    @csrf
                </form>
                <a href="#" class="dropdown-item" onclick="document.getElementById('logout').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i>Se déconnecter
                    <span class="float-right text-muted text-sm"></span>
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
