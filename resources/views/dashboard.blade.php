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
                        <div class="ui-trans-wrapper d-grid gap-2" id='entry-div' style='display:hidden'>
                        </div>
                        <div class='ui-display-wrapper d-grid gap-2 centered' id='add-new-item'>
                            <div class='border border-info rounded-2' role='button' onclick="dashboard.list('entry');">List Bills and Income</div>
                            <div class='border border-info rounded-2' role='button' onclick="dashboard.add('entry');">Add New Bill or Income</div>
                        </div>
                    </div>
                    <div class='col-lg-4 col-12'>
                        <div class='ui-display-wrapper d-grid gap-2'>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.list('account');">Accounts</div>
                            <div id='account-div' class="d-grid gap-2" style='display:hidden'></div>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.add('account');">Add New Account</div>
                        </div>

                        <div class='ui-display-wrapper d-grid gap-2'>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.list('party');">Payors / Payees</div>
                            <div id='party-div' class="d-grid gap-2" style='display:hidden'></div>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.add('party');">Add New Payor / Payee</div>
                        </div>

                        <div class='ui-display-wrapper d-grid gap-2'>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.list('category');">Categories</div>
                            <div id='category-div' class="d-grid gap-2" style='display:hidden'></div>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.add('category');">Add New Category</div>
                        </div>

                        <div class='ui-display-wrapper d-grid gap-2'>
                            <div class='border border-info rounded-2 centered' role='button' onclick="dashboard.show('user')">Profile</div>
                            <div class='border border-info rounded-2 centered' role='button' onclick="utility.logout()">Log Out</div>
                        </div>
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
