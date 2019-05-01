<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($previousPage) && $previousPage == 'admin.order.shop')
    <meta http-equiv="refresh" content="5">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>New York Deli</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('lib/materialize/dist/css/materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<body>
    <header>
        @include('layouts._site._nav')
    </header>
    <main>
        <input type="hidden" class="msg-text" value="{{ Session::get('message') }}">
        <input type="hidden" class="msg-class" value="{{ Session::get('typeMessage') }}">
        <input type="hidden" class="current-menu" value="{{ Session::get('$currentMenu') }}">
        <input type="hidden" name="active_tab" id="active_tab" value="{{ Session::get('active_tab') }}" />
        @yield('content')
    </main>
    @include('layouts._site._footer')
    <!-- Scripts -->
    <script src="{{asset('lib/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('lib/materialize/dist/js/materialize.js')}}"></script>
    <script src="{{asset('lib/maskmoney/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('lib/mask/jquery.mask.js')}}"></script>
    <script src="{{asset('js/init.js')}}"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.4/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyC5CVtfHq15tI2k6RvUXWlm0ZKwkR6zEXQ",
            authDomain: "new-york-deli-mobile-9dcc5.firebaseapp.com",
            databaseURL: "https://new-york-deli-mobile-9dcc5.firebaseio.com",
            projectId: "new-york-deli-mobile-9dcc5",
            storageBucket: "new-york-deli-mobile-9dcc5.appspot.com",
            messagingSenderId: "955527324045"
        };
        firebase.initializeApp(config);
    </script>
</body>
</html>
