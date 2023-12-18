@php
    use Illuminate\Support\Str;
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link d-block">
        <img src="https://blooapp.live/assets/images/bloo_logo_white.png" alt="Bloo" class="brand-image">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->

                @if(auth()->user()->roles->pluck('id')[0] === 1)
                    <li  class="nav-item ">
                        <a href="{{route('operation.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th  "></i>
                            <p>
                                Tableau de bord
                            </p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->roles->pluck('id')[0] !== 1)
                    <li  class="nav-item active">
                        <a href="{{route('operation.index')}}" class="nav-link active <?php echo (Str::startsWith($route, 'operation')) ? "active" : '' ?>">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Opérations25
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-comment-alt"></i>
                        <p>
                            Messages
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Utilisateurs
                        </p>
                    </a>
                </li>

                @if(auth()->user()->roles->pluck('id')[0] === 1)
                    <li  class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Paiements
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="{{route('role.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Roles
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="{{route('permission.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Permissions
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('countries.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Pays
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Paramètres
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->

