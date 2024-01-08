@extends('layout/default')


@section('title')
MUB ShopBasket
@endsection



@section('css')
<link rel="stylesheet" href="/css/basketCase.css">
@endsection

@section('content')
    <div class="content">
        <div class="message">
            @if ($message = Session::get('success'))
                <p>{{ $message }}</p>
            @endif
        </div>
        <div class="basketCasee">
            <table>
                <thead>
                    <th>Nom du Produit</th>
                    <th title="Quantity">Quantité</th>
                    <th > Prix à l'unité</th>
                    <th > Enlever </th>
                </thead>
                <tbody id="items_basketCase">
                </tbody>
            </table>
            <div class="validation">
                <div id="total"></div>
                <div>
                    <button onclick="cleanShopBasket()" class="viderbasketCase">Vider le basketCase</button>
                </div>
                <form onsubmit="return false">
                    @csrf
                    <button id="validerbasketCase" onclick="validationShopBasket()">Valider le basketCase</button>
                </form>

            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>display_basketCase()</script>
@endsection
