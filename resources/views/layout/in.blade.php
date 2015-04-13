@extends('layout.abstract')

@section('body')
<body class="it it-in-body">
    <nav class="navbar navbar-default navbar-static-top it-nav">
        <div class="container">
            <div class="it-hack-center">
                <a class="navbar-text lead it-link-no-hover" href="/feed">Instatranslate</a>
            </div>
            <div class="navbar-header navbar-left">
                <a class="it-navbar-logo" href="/feed">
                    <img alt="{{ \Auth::getUser()->getFullName() }}" src="{{ \Auth::getUser()->getProfilePicture() }}" class="img-rounded it-img-header">
                </a>
            </div>
            <div class="navbar-left">
                <a class="navbar-text lead btn-link it-link-no-hover" href="/feed">{{ \Auth::getUser()->getUsername() }}</a>
            </div>
            <div class="navbar-right">
                <a class="navbar-text btn-link it-link-no-hover it-logout" href="/logout">Log Out</a>
            </div>
        </div>
    </nav>
    <div class="container it-content">
        @yield('content')
    </div>
</body>
@stop
