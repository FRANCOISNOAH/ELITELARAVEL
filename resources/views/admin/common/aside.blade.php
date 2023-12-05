<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link d-block">
        <img src="{{ asset('assets/images/bloo_logo_white.png') }}" alt="Bloo" class="brand-image">
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

                <li class="nav-item <?php echo (Str::startsWith($route, 'operation')) ? "active" : '' ?>">
                    <a href="{{route("operation.index")}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{trans("Operations")}}
                        </p>
                    </a>
                </li>

                <li class="nav-item <?php echo (Str::startsWith($route, 'user')) ? "active" : '' ?>">
                    <a href="{{route("user.index")}}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            @lang('Members')
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->
