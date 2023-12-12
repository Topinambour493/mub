<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <link rel="stylesheet" href="/css/header.css"/>
        @yield('css')
        <meta charset="UTF-8">
        <meta name="_token" content="{{ csrf_token() }}">
    </head>
    <body>
        <header>
            <div class="gauche">
                <div class="MUB"><a href="{{ route('catalog') }}"><img src="/images/header/logo.png" alt="MUB"></a></div>
            </div>
            <div class="milieu">
                @if (Auth::check())
                    @if(Auth::user()->admin == 1)
                        <a href="{{ route('stats') }}" class="menu">Statistiques</a>
                        <a href="{{ route('adminNewProduct') }}" class="menu">Ajout Produit</a>
                    @endif
                @endif
                <a href="{{ route('catalog') }}" class="menu">Catalogue</a>
                <div id="notification"></div>
            </div>
            <div class="droite">
                <div class="haut">
                    @if (Auth::check())
                        <a href="{{ route('deconnexion') }}" class="auth">Deconnexion</a>
                        <div class="user_connected">
                            @if(Auth::user()->admin == 1)
                                <img src="/images/header/couronne.png" alt="couronne d'admin" class="containcouronne">
                            @endif
                            <span>{{ Auth::user()->name }}</span>
                            <span>{{ Auth::user()->lastname }}</span>
                        </div>
                    @else
                        <a href="{{ route('inscription') }}" class="auth" onclick="localStorage.clear()">Inscription</a>
                        <a href="{{ route('connexion') }}" class="auth" onclick="localStorage.clear()">Connexion</a>
                    @endif
                </div>
                <div class="bas">
                    @if(Auth::check())
                        @if(Auth::user()->current_order > 1)
                            <a href="{{ route('history') }}"><img alt="historique" class="containHistory"><a>
                        @endif
                    @endif
                    <a href="{{ route('shopBasket') }}"><img alt="panier" class="shopBasket"></a>
                    <p id="nb_products">0</p>
                </div>
            </div>
        </header>
        <div class="fond_opaque">
            <div class="RGPD">
                <div class="MUB"><img src="/images/header/logo.png" alt="MUB"></div>
                <div class="question">
                    En cliquant sur “Accepter”, vous consentez à l’utilisation de cookies pour l’ensemble des finalités ci-dessus.
                </div>
                <div class="reponse">
                    <button id="Accept" onclick="close_popup()">Accepter</button>
                </div>
            </div>
        </div>
        @yield('content')
        <footer>
            <div class="reseau">
                <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a><br>
                <a href="https://twitter.com/?lang=fr" target="_blank"><i class="fab fa-twitter"></i></a><br>
            </div>
        </footer>
        <script type="text/javascript" src="/js/RGPD.js"></script>
        <script type="text/javascript" src="/js/gestion_panier.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <script>alertify.set('notifier','position', 'top-center');
        </script>
        <script>display_nb_products()</script>
        @yield('script')
    </body>
</html>
