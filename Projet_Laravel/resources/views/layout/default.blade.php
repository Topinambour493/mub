<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/header.css"/>
        @yield('css')
        <meta charset="UTF-8">
        <meta name="_token" content="{{ csrf_token() }}">
    </head>
    <body>
        <header>
            <div class="gauche">
                <div class="MUB"><a href="{{ route('catalogue') }}"><img src="/images/header/logo.png" alt="MUB"></a></div>
            </div>
            <div class="milieu">
                @if (Auth::check())
                    @if(Auth::user()->admin == 1)
                        <a href="{{ route('stats') }}" class="menu">Statistiques</a>
                        <a href="{{ route('adminNouveauProduit') }}" class="menu">Ajout Produit</a>
                    @endif
                @endif
                <a href="{{ route('catalogue') }}" class="menu">Catalogue</a>
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
                        @if(Auth::user()->commande_en_cours > 1)
                            <a href="{{ route('historique') }}"><img alt="historique" class="containhistorique"><a>
                        @endif
                    @endif
                    <a href="{{ route('panier') }}"><img alt="panier" class="panier"></a> 
                    @if (Auth::check())
                        <p id="nb_produits">0</p>
                    @endif
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
        <script>display_nb_produits()</script>
        @yield('script')
    </body>
</html>
