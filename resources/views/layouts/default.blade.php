<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="OZ5EaazJ8k-vftAyTNRIeoewQVsBYfDNSkqTnlYwt-Y" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hibbo</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('asset/css/font-awesome/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/jquery-ui/social/jquery.ui.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/main.css') }}" rel="stylesheet">

    @yield('css')

</head>
<body>
    <header>
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center title">Hibbo</h1>
            </div>
        </div>
    </header>
    <div class="main">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <footer></footer>

<script src="{{ asset('asset/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
@yield('js')