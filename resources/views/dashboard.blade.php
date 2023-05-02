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
                    <div class='col col-12 col-lg-8'>
                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="dashboard.add('entry', false);"><i class='fa-regular fa-plus-large'></i>&nbsp;&nbsp;New Expense</div></div>
                            <div class="col-6"><div class='btn-app-primary centered' role='button' onclick="dashboard.add('entry', true);"><i class='fa-regular fa-plus-large'></i>&nbsp;&nbsp;New Income</div></div>
                        </div></div>
                    </div>
                    <div class='col order-first order-lg-last col-12 col-lg-4'>
                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-6 offset-xl-2 col-xl-4"><div class='btn-app-primary centered' role='button' onclick="dashboard.show('profile', 0);"><i id='category-icon' class='fa-thin fa-id-card'></i>&nbsp;&nbsp;Profile</div></div>
                            <div class="col-6 col-xl-4"><div class='btn-app-primary centered' role='button' onclick="utility.logout();"><i id='category-icon' class='fa-thin fa-person-to-door'></i>&nbsp;&nbsp;Log Out</div></div>
                        </div></div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-lg-8 col-12'>
                        <div class="container-fluid mb-2 app-hidden" id='entry-div'></div>
                    </div>

                    <div class='col-lg-4 col-12'>
                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-10 offset-xl-2 col-xl-6"><div class='btn-app-primary clickable' onclick="dashboard.listaccount();" data-open='false'><span class='display-title'><i id='account-icon' class='fa-regular fa-chevrons-right'></i> Accounts</span></div></div>
                            <div class="col-2"><div class='btn-app-primary centered clickable' onclick="dashboard.add('account');"><i class='fa-regular fa-plus-large'></i></div></div>
                            <div class="container-fluid mb-2 app-hidden" id='account-div'></div>
                        </div></div>

                        <div class='container-fluid mb-2'><div class='row'>
                            <div class="col-10 offset-xl-2 col-xl-6"><div class='btn-app-primary clickable' onclick="dashboard.listcategory();" data-open='false'><span class='display-title'><i id='category-icon' class='fa-regular fa-chevrons-right'></i> Categories</span></div></div>
                            <div class="col-2"><div class='btn-app-primary centered clickable' onclick="dashboard.add('category');"><i class='fa-regular fa-plus-large'></i></div></div>
                            <div class="container-fluid mb-2 app-hidden" id='category-div'></div>
                        </div></div>

                        <div class='container-fluid mb-2 subscribe-div app-hidden' ><div class='row'>
                            <div class="col-12 offset-xl-2 col-xl-8"><div class='btn-app-primary centered' onclick="subscription.showOffer();"><span class='subscribe-button'><i class='fa-regular fa-face-smiling-hands'></i> Subscribe</span></div></div>
                        </div></div>

                        <div class='container-fluid mb-2 reports-div app-hidden' ><div class='row'>
                            <div class="col-12 offset-xl-2 col-xl-8"><div class='btn-app-primary centered' onclick="reports.show();"><span class='reports-button'><i class='fa-regular fa-download'></i> Reports</span></div></div>
                        </div></div>

                        <div class='container-fluid mb-2 help-div'><div class='row'>
                            <div class="col-12 offset-xl-2 col-xl-8"><div class='btn-app-primary centered' onclick="help.show();"><span class='help-button'><i class='fa-regular fa-person-drowning'></i> Help</span></div></div>
                        </div></div>
                    </div>
                </div>
            </div>
        </main>
        <div class='modal' id='genericModal' tabindex='-1'>
            <div class='container-fluid'>
                <div class='row'>
                <div class='col-12 offset-lg-1 col-lg-10 offset-xl-2 col-xl-8'>
                    <div class='modal-dialog mw-100'>
                <div class='modal-content'>
                    <div class='modal-header'></div>
                    <div class='modal-body'></div>
                    <div class='modal-footer'></div>
                </div>
            </div>
            </div>
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
