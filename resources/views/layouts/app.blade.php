<!DOCTYPE html>
<html lang="en">
@include('partials.head')
@if (Auth::check())

    <body>
        <div class="wrapper">
            <!-- Sidebar -->
            <div class="sidebar" data-background-color="dark">
                <div class="sidebar-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ url('/') }}" class="logo">
                            <!-- Forma de poner la ruta de img -->
                            @if ($configuration && $configuration->file)
                                <img src="{{ asset('storage/' . $configuration->logo) }}" width="100" alt="Logo">
                            @else
                                <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}"
                                    alt="Logo predeterminado" class="logo-img" />
                            @endif
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
                        <ul class="nav nav-secondary">
                            <li class="nav-item ">
                                <a href="{{ route('municipal-deposit.index') }}">
                                    <i class="fas fa-industry"></i>
                                    <p>{{ __('messages.municipal-deposit') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('time-entries.index') }}">
                                    <i class="fas fa-clock"></i>
                                    <p>{{ __('messages.time_control') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('employees.index') }}">
                                    <i class="fas fa-users"></i>
                                    <p>{{ __('messages.employees') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">

                                <a href="{{ route('locations.index') }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>{{ __('messages.location') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">

                                <a href="{{ route('companies.index') }}">
                                    <i class="fas fa-building"></i>
                                    <p>{{ __('messages.companies') }}</p>
                                </a>
                            </li>
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="fa fa-ellipsis-h"></i>
                                </span>
                                <h4 class="text-section">{{ __('messages.tools') }}</h4>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('events.index') }}">
                                    <i class="fas fa-calendar"></i>
                                    <p>{{ __('messages.calendar') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rates.index') }}">
                                    <i class="fas fa-file-invoice"></i>
                                    <p>{{ __('messages.cars_invoices') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('incidents.index') }}">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <p>{{ __('messages.incidences') }}</p>
                                </a>
                            </li>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="{{ route('tasks.index') }}">
                                        <i class="fas fa-tasks"></i> <!-- Icono de tareas -->
                                        <p>{{ __('messages.tasks') }}</p>
                                    </a>
                                </li>
                            </ul>

                            <li class="nav-item ">
                                <a href="{{ route('documents-gest.index') }}">
                                    <i class="fas fa-folder"></i>
                                    <p>{{ __('messages.documental_gestion') }}</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('configuration.index') }}">
                                    <i class="fas fa-cog"></i>
                                    <p>{{ __('messages.configuration') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}">
                                    <i class="fas fa-user"></i>
                                    <p>{{ __('messages.users') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('accesslogs.index') }}">
                                    <i class="fas fa-list"></i>
                                    <p>{{ __('messages.access_logs') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vehicles.index') }}">
                                    <i class="fas fa-car"></i>
                                    <p>{{ __('messages.vehicle') }}</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                            <li class="nav-item">
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <p>
                                        <p>{{ __('messages.logout') }}</p>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Sidebar -->

            <div class="main-panel">
                <div class="main-header">
                    <div class="main-header-logo">
                        <!-- Logo Header -->
                        <div class="logo-header" data-background-color="dark">
                            <a class="logo">
                                <img src="{{ Vite::asset('resources/dist/img/kaiadmin/logo_light.svg') }}"
                                    alt="navbar brand" class="navbar-brand" height="20" />
                            </a>
                            <div class="nav-toggle">
                                <button class="btn btn-toggle toggle-sidebar">
                                    <i class="gg-menu-right"></i>
                                </button>
                                <button class="btn btn-toggle sidenav-toggler">
                                    <i class="gg-menu-left"></i>
                                </button>
                            </div>
                            <button class="topbar-toggler more">
                                <i class="gg-more-vertical-alt"></i>
                            </button>
                        </div>
                        <!-- End Logo Header -->
                    </div>
                    <!-- Navbar Header -->
                    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                        <div class="container-fluid">

                            <div class="language-switcher m-3">
                                <a href="{{ url('lang/en') }}" class="btn btn-primary">English</a>
                                <a href="{{ url('lang/es') }}" class="btn btn-secondary">Español</a>
                            </div>
                            <input type="hidden" id="user_role"
                                value="{{ Auth::check() ? Auth::user()->getRole() : 'client' }}">

                            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link text-gray-500" href="{{ route('frontend.index') }}"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-user-tie"></i>
                                    </a>
                                </li>
                                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                        role="button" aria-expanded="false" aria-haspopup="true">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                                        <form class="navbar-left navbar-form nav-search">
                                            <div class="input-group">
                                                <input type="text" placeholder="Search ..."
                                                    class="form-control" />
                                            </div>
                                        </form>
                                    </ul>
                                </li>
                                <li class="nav-item topbar-icon dropdown hidden-caret">
                                    <a class="nav-link" data-bs-toggle="dropdown" href="#"
                                        aria-expanded="false">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                    <div class="dropdown-menu quick-actions animated fadeIn">
                                        <div class="quick-actions-header">
                                            <span class="title mb-1">Acciones Rápidas</span>
                                        </div>
                                        <div class="quick-actions-scroll scrollbar-outer">
                                            <div class="quick-actions-items">
                                                <div class="row m-0">
                                                    <a class="col-6 col-md-4 p-0" href="{{ route('events.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-danger rounded-circle">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.calendar') }}</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('locations.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-warning rounded-circle">
                                                                <i class="fas fa-map"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.location') }}</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('incidents.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-info rounded-circle">
                                                                <i class="fas fa-file-excel"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.incidences') }}</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="{{ route('configuration.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-primary rounded-circle">
                                                                <i class="fas fa-cogs"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.configuration') }}</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="{{ route('tasks.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-success rounded-circle">
                                                                <i class="fas fa-tasks"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.tasks') }}</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="{{ route('time-entries.index') }}">
                                                        <div class="quick-actions-item">
                                                            <div class="avatar-item bg-warning rounded-circle">
                                                                <i class="fas fa-clock"></i>
                                                            </div>
                                                            <span class="text">{{ __('messages.time_control') }}</span>
                                                        </div>
                                                    </a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <header-user></header-user>
                                {{-- Llamamos el componente de vue  --}}

                                <li class="nav-item topbar-user dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                        aria-expanded="false">
                                        <div class="avatar-sm">
                                            @if (Auth::check() && $user->profile_image)
                                                <!-- Si el usuario tiene una imagen de perfil -->
                                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                    class="avatar-img rounded-circle" alt="User Image">
                                            @else
                                                <!-- Si no tiene imagen de perfil, mostramos una imagen predeterminada -->
                                                <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}"
                                                    alt="Imagen predeterminada" class="avatar-img rounded-circle" />
                                            @endif
                                        </div>
                                        <span class="profile-username">
                                            <span class="op-7">{{ __('messages.hello') }}</span>
                                            <span id="user" data-user="{{ Auth::user() }}"
                                                class="user_profile_name fw-bold">{{ Auth::user() ? Auth::user()->name : 'invitado' }}</span>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg">
                                                        @if (Auth::check() && $user->profile_image)
                                                            <a href="{{ route('users.profile') }}">
                                                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                                    class="avatar-img rounded-circle"
                                                                    alt="User Image">
                                                            </a>
                                                        @else
                                                            <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}"
                                                                alt="Imagen predeterminada"
                                                                class="avatar-img rounded-circle" />
                                                        @endif
                                                    </div>
                                                    <div class="u-text">
                                                        <h4 id="user" class="user_profile_name">
                                                            {{ Auth::user() ? Auth::user()->name : 'invitado' }}</h4>
                                                        <p id="user" class="user_email" class="text-muted">
                                                            {{ Auth::user() ? Auth::user()->email : '' }}</p>
                                                        <a href="{{ route('users.profile') }}"
                                                            class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('configuration.index') }}">
                                                    {{ __('messages.configuration') }}
                                                    <i class="fas fa-cog"></i>

                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form id="logout-form2" action="{{ route('logout') }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>

                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form2').submit();"
                                                    aria-label="Cerrar sesión">
                                                    {{ __('messages.logout') }}
                                                    <i class="fas fa-sign-out-alt"></i>

                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
@endif
<div class="container">
    <div id="app" class="page-inner">
        @yield('content')
    </div>
</div>
@if (Auth::check())
    <footer class="footer">
        <div class="container-fluid text-center">
            <div class="copyright">
                <p>&copy; 2024 <strong>Grúas Andalucia S.A.</strong> - Todos los derechos reservados.</p>
            </div>
            <div class="contact-info">
                <p>Atención 24/7: <strong>(123) 456-7890</strong></p>
            </div>
        </div>
    </footer>
@endif
</div>

<div class="custom-template">
    <div class="title">Settings</div>
    <div class="custom-content">
        <div class="switcher">
            <div class="switch-block">
                <h4>Logo Header</h4>
                <div class="btnSwitch">
                    <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                    <br />
                    <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                    <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                </div>
            </div>
            <div class="switch-block">
                <h4>Navbar Header</h4>
                <div class="btnSwitch">
                    <button type="button" class="changeTopBarColor" data-color="dark"></button>
                    <button type="button" class="changeTopBarColor" data-color="blue"></button>
                    <button type="button" class="changeTopBarColor" data-color="purple"></button>
                    <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                    <button type="button" class="changeTopBarColor" data-color="green"></button>
                    <button type="button" class="changeTopBarColor" data-color="orange"></button>
                    <button type="button" class="changeTopBarColor" data-color="red"></button>
                    <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                    <br />
                    <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                    <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                    <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                    <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                    <button type="button" class="changeTopBarColor" data-color="green2"></button>
                    <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                    <button type="button" class="changeTopBarColor" data-color="red2"></button>
                </div>
            </div>
            <div class="switch-block">
                <h4>Sidebar</h4>
                <div class="btnSwitch">
                    <button type="button" class="changeSideBarColor" data-color="white"></button>
                    <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                    <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-toggle">
        <i class="icon-settings"></i>
    </div>
</div>
<!-- End Custom template -->
@include('partials.footer')
</div>




</body>


</html>
