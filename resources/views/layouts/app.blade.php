<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark light">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{Config::get('app.name')}}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/resources.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/billminder.css') }}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('/js/resources.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/js/billminder.js') }}"></script>



</head>
<body class='dashboard'>

<!--
    // menu system goes bye-bye.

<nav id="console" class="navbar fixed-top navbar-expand-lg">
    <a class="navbar-brand" href="/console" id="reloader">
    <img src="{{ asset('/images/logo.png') }}" alt="GraniteSME Logo" style="margin-bottom: 3px; max-height:35px;"/>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto" id='mainmenu'>
    </ul>

    <ul class="navbar-nav navbar-right">
        <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" id="featureDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fa-regular fa-fw fa-sparkles"></i>&nbsp;Features</span>&nbsp;</span>
            </a>
            <ul id="feature-list" class="dropdown-menu dropdown-menu-right pull-right" aria-labelledby="featureDropdown">

                <li><a class="dropdown-item" id='news-item' href="#">
                    <i class="fa-regular fa-fw fa-newspaper"></i>&nbsp;Newsfeeds
                </a></li>

                <li><a class="dropdown-item" id='chat-item' href="#">
                    <i class="fa-regular fa-fw fa-messages"></i>&nbsp;Chatrooms
                </a></li>

                <li><a class="dropdown-item" id='journal-item' href="#">
                    <i class="fa-regular fa-fw fa-book"></i>&nbsp;Journals
                </a></li>

                <li><a class="dropdown-item" id='msgs-item' href="#">
                    <i class="fa-regular fa-fw fa-envelope"></i>&nbsp;Mailbox
                </a></li>

            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-regular fa-fw fa-user"></i>&nbsp;<span id="username">{{ Auth::user()->name }}</span>&nbsp;<span class="caret"></span>
            </a>
            <ul id="profile-list" class="dropdown-menu dropdown-menu-right pull-right" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" id='theme-item' href="#">
                    <input type='checkbox' id='cb-dark-theme'>&nbsp;Dark Theme
                </a></li>

                <li><a class="dropdown-item" id='profile-item' href="#">
                    <i class="fa-regular fa-fw fa-circle-user"></i>&nbsp;Profile
                </a></li>
                <li><a class="dropdown-item" id='connections-item' href="#">
                    <i class="fa-regular fa-fw fa-users"></i>&nbsp;Connections
                </a></li>
                <li><a class="dropdown-item" id='referrals-item' href="#">
                    <i class="fa-regular fa-fw fa-dollar"></i>&nbsp;Referrals
                </a></li>
                <li><hr class='dropdown-divider'></li>
                <li><a class="dropdown-item" id='logout' href="#"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="fa-regular fa-fw fa-sign-out-alt"></i>&nbsp;Log Out
                </a></li>
            </ul>
        </li>
        </ul>
  </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
</form>

-->

<div class="page-wrapper">
    <main class="page-content">
        <div class='titleFixed'></div>
        <div class="container-fluid">
            @yield('content')
        </div>
        <script>
        </script>
    </main>
    <div class='modal' id='genericModal' tabindex='-1'>
        <div class='modal-dialog' style='max-width:60%'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'></h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'></div>
                <div class='modal-footer'></div>
            </div>
        </div>
    </div>
    <div class="overlay">
    </div>
    </div>
</body>
<script>
    utility.initialize();
</script>
</html>
