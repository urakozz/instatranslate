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
    @if(App::environment('production'))
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter29693235 = new Ya.Metrika({id:29693235});
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="//mc.yandex.ru/watch/29693235" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    @endif
</body>
@stop
