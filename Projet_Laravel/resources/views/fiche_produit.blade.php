@extends('layout/default')

@section('title')
    MUB produit
@endsection

@section('css')
    <link rel="stylesheet" href="/css/produit.css">
@endsection

@section('content')
    <h1>
        <div class="nomduproduit">{{$produit->nom}}</div><br>
        <div class="infos_produit">
            <div class="image">
                <img src="/disk_products/{{$produit->image}}" alt="{{$produit->nom}}" class="contain">
            </div>
            <div class="paragraphe">
                <div class= "description">Description du produit: <br>{{$produit->description}}</div>
                <div class=prix>Prix : {{$produit->prix}}€</div>
                @if ($errors->any())
                    <div class="alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <form onsubmit="return false">
                    @csrf
                    <input type="hidden" name="produit_id" value="{{$produit->id}}">
                    <label for="quantité">Quantité:</label>
                    <div class="quantite">
                        <input type="number" id="quantité" name="quantité" value="1" min="1" max="{{$produit->stock}}" required>
                        <button @if (Auth::check()) onclick="achat({{ $produit->id}},'{{ $produit->nom}}',{{ $produit->prix}},{{$produit->stock}})" @else onclick="viewLogin()" @endif type="submit" class="envoie">valider</button>
                    </div>
                </form>
                <div class="nb-exemplaire">Il ne reste que {{$produit->stock}} exemplaires!</div>
                @if (Auth::check())
                    @if(Auth::user()->admin == 1)
                        <a href="{{ route("modification_fiche_produit", [$produit->id]) }}"><button> Modifier la fiche produit</button></a>
                    @endif
                @endif
            </div>
        </div>
    </h1>
@endsection
