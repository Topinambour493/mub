@extends('layout/default')

@section('title')
    MUB Historique commandes
@endsection

@section('css')
    <link rel="stylesheet" href="/css/history.css">
@endsection

@section('content')
    <div class="content">
        @foreach ($orders as $shopBasketItems)
            <div class="basketCasee">
                <div class="numéroCommande">Commande {{ $shopBasketItems[0]->order }} </div>
                <table>
                    <thead>
                    <th>Nom du Produit</th>
                    <th title="Quantity">Quantité</th>
                    <th> Prix à l'unité</th>
                    </thead>
                    <tbody>
                    @foreach ($shopBasketItems as $item)
                        <tr>
                            <td class="nameprod">
                                <a href="{{ route('productSheet', [$item->product_id]) }}"><p
                                        class="name">{{ $item->name_product }}</p></a>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td class="price"> {{ $item->price }}€</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="centre">Total: {{ $shopBasketItems->total_order }}€</div>
            </div>
        @endforeach
    </div>
@endsection
