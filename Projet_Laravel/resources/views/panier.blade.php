@extends('layout/default')


@section('title')
MUB Panier
@endsection



@section('css')
<link rel="stylesheet" href="/css/panier.css">
@endsection

@section('content')
    <div class="content">
        <div class="message">
            @if ($message = Session::get('success'))
                <p>{{ $message }}</p>
            @endif
        </div>
        <div class="paniere">
            <table>
                <thead>
                    <th>Nom du Produit</th>
                    <th title="Quantity">Quantité</th>
                    <th > Prix à l'unité</th>  
                    <th > Enlever </th>
                </thead>
                <tbody id="items_panier">
                </tbody>
            </table>
            <div class="validation">
                <div id="total"></div>
                <div>
                    <button onclick="videPanier()" class="viderpanier">Vider le panier</button>
                </div>
                <form onsubmit="return false">
                    @csrf
                    <button id="validerpanier" onclick="validePanier()">Valider le panier</button>
                </form>

            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>display_panier()</script>
@endsection