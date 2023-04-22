<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark light">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Config::get('app.name') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/resources.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/billminder.css') }}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('/js/resources.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/js/billminder.js') }}"></script>



</head>

<body class="dashboard">
    <div class="page-wrapper">
        <main class="page-content">

            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-lg-8 col-12'>
                        <div class="container-fluid mb-2" id='entry-div' style='display:hidden'></div>
                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="dashboard.add('entry');"><i class='fa-regular fa-plus-large'></i> Add A Bill</div></div>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="dashboard.add('entry');"><i class='fa-regular fa-plus-large'></i> Add Income</div></div>
                        </div></div>
                    </div>

                    <div class='col-lg-4 col-12'>
                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-9"><div class='btn-app-primary clickable' onclick="dashboard.list('account');"><span class='display-title'><i id='account-icon' class='fa-regular fa-chevrons-right'></i> Accounts</span></div></div>
                            <div class="col-3"><div class='btn-app-primary centered clickable' onclick="dashboard.add('account');"><i class='fa-regular fa-plus-large'></i></div></div>
                            <div class="container-fluid mb-2" id='account-div' style='display:hidden'></div>
                        </div></div>

                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-9"><div class='btn-app-primary clickable' onclick="dashboard.list('category');"><span class='display-title'><i id='category-icon' class='fa-regular fa-chevrons-right'></i> Categories</span></div></div>
                            <div class="col-3"><div class='btn-app-primary centered clickable' onclick="dashboard.add('category');"><i class='fa-regular fa-plus-large'></i></div></div>
                            <div class="container-fluid mb-2" id='category-div' style='display:hidden'></div>
                        </div></div>

                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="dashboard.show('user');"><i id='category-icon' class='fa-thin fa-id-card'></i> Profile</div></div>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="utility.logout();"><i id='category-icon' class='fa-thin fa-person-to-door'></i> Log Out</div></div>
                        </div></div>
                    </div>
                </div>
            </div>
        </main>
        <div class='modal' id='genericModal' tabindex='-1'>
            <div class='modal-dialog' style='max-width:60%'>
                <div class='modal-content'>
                    <div class='modal-header'></div>
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
    dashboard.initialize();
</script>


</html>
