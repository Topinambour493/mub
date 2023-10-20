@extends('layout/default')

@section('title')
    MUB Historique commandes
@endsection

@section('css')
    <link rel="stylesheet" href="/css/historique.css">
@endsection

@section('content')
    <div class="content">
        @foreach ($commandes as $panierItems)
            <div class="paniere">
                <div class="numéroCommande">Commande {{ $panierItems[0]->commande }} </div>
                <table>
                    <thead>
                    <th>Nom du Produit</th>
                    <th title="Quantity">Quantité</th>
                    <th > Prix à l'unité</th>
                    </thead>
                    <tbody>
                        @foreach ($panierItems as $item)
                            <tr>
                                <td class="nomprod">
                                    <a href="{{ route('fiche_produit', [$item->produit_id]) }}"><p class="nom">{{ $item->nom_produit }}</p></a>
                                </td>
                                <td>{{ $item->quantite }}</td>
                                <td class="prix"> {{ $item->prix }}€</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="centre">Total: {{ $panierItems->total_commande }}€ </div>
            </div>
        @endforeach
    </div>
@endsection