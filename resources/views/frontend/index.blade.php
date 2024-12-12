<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.head')
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #app {
            min-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
            position: absolute;
            bottom: 0;
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header.header {
            background-color: #1a1a1a;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-logo .logo-header {
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: transparent;
        }

        .sidebar-logo .logo-header a.logo img {
            border-radius: 4px;
            width: 80px;
        }

        .nav-toggle button {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        .nav-toggle button:hover {
            color: #888;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .topbar-user .avatar-sm img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #666;
        }

        .topbar-user .profile-username {
            display: flex;
            flex-direction: column;
            font-size: 14px;
            color: #ccc;
        }

        .topbar-user .profile-username .user_profile_name {
            font-weight: bold;
            color: white;
        }

        .dropdown-menu {
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 4px;
            margin-top: 10px;
            padding: 10px;
            width: 220px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-menu .avatar-lg img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid #666;
        }

        .dropdown-menu .u-text {
            flex: 1;
        }

        .dropdown-menu .u-text h4 {
            margin: 0;
            font-size: 16px;
            color: white;
        }

        .dropdown-menu .u-text p {
            margin: 0;
            font-size: 12px;
            color: #ccc;
        }

        .dropdown-menu .dropdown-item {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #444;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #444;
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="sidebar-logo">
            <div class="logo-header" >
                <a href="{{ url('/') }}" class="logo">
                    @if ($configuration && $configuration->file)
                        <img src="{{ asset('storage/' . $configuration->logo) }}" width="100" alt="Logo">
                    @else
                        <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}" alt="Logo predeterminado"
                            class="logo-img" />
                    @endif
                </a>
            </div>
        </div>

        <li class="nav-item topbar-user dropdown hidden-caret">
            @if (Auth::check() && Auth::user()->hasRole('admin'))
                <a class="nav-link text-gray-500" href="{{ route('employee') }}" role="button" aria-haspopup="true">
                    <i class="fas fa-desktop ml-2" style="font-size: 18px; color: white;"></i>
                </a>
            @endif
            <a class="dropdown-toggle profile-pic d-flex align-items-center " data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <span class="profile-username d-flex p-1 ">
                    <span id="user" data-user="{{ Auth::user() }}"class="user_profile_name fw-bold ">
                        {{ Auth::user() ? Auth::user()->name : 'invitado' }}
                    </span>
                </span>

                <div class="avatar-sm">
                    @if (Auth::check() && $user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="avatar-img rounded-circle"
                            alt="User Image">
                    @else
                        <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}" alt="Imagen predeterminada"
                            class="avatar-img rounded-circle" />
                    @endif
                </div>
            
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg">
                                @if (Auth::check() && $user->profile_image)
                                    <a href="{{ route('users.profile') }}">
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                            class="avatar-img rounded-circle" alt="User Image">
                                    </a>
                                @else
                                    <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}"
                                        alt="Imagen predeterminada" class="avatar-img rounded-circle" />
                                @endif
                            </div>
                            <div class="u-text">
                                <h4 id="user" class="user_profile_name">
                                    {{ Auth::user() ? Auth::user()->name : 'invitado' }}</h4>
                                <p id="user" class="user_email" class="text-muted">
                                    {{ Auth::user() ? Auth::user()->email : '' }}</p>        
                            </div>
                        </div>
                    </li>
                    <li>
                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form2').submit();"
                            aria-label="Cerrar sesión">
                            Logout
                        </a>
                    </li>
            </ul>
        </li>
    </header>

    <div id="app">
        {{-- <client-crud :vehicles="{{ json_encode($vehicles) }}"></client-crud>
         --}}
        <client-page :vehicles="{{ json_encode($vehicles) }}" ></client-page>
    </div>

    @include('partials.footer')

</body>

</html>
