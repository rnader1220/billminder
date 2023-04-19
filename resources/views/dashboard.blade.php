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
                        <div class='ui-display-wrapper' id='balance-list'>
                            Balance List should have border. internal elements go here
                            Balance Here
                        </div>
                        <div class='ui-form-wrapper' id='add-new-item'>
                            <a href='#' onclick="dashboard.add('expense');">Add New Bill</a><br>
                            <a href='#' onclick="dashboard.add('income');">Add New Income</a>
                        </div>
                    </div>
                    <div class='col-lg-4 col-12'>
                        <div class='ui-trans-wrapper' id='options-list'>
                            options list should be borderless. borders will be on each option

                            <br><a href='#' onclick='utility.logout()'>logout</a>
                        </div>
                    </div>
                </div>
            </div>
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
    //utility.mainmenu();
</script>


</html>
