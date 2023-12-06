@extends('layout/default')

@section('title')
    MUB produit
@endsection

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection

@section('content')
    <h1>
        <div class="nomduproduct">{{$product->nom}}</div><br>
        <div class="infos_product">
            <div class="image">
                <img src="/disk_products/{{$product->image}}" alt="{{$product->nom}}" class="contain">
            </div>
            <div class="paragraphe">
                <div class= "description">Description du produit: <br>{{$product->description}}</div>
                <div class=prix>Prix : {{$product->prix}}€</div>
                @if ($errors->any())
                    <div class="alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <form onsubmit="return false">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <label for="quantité">Quantité:</label>
                    <div class="quantite">
                        <input type="number" id="quantité" name="quantité" value="1" min="1" max="{{$product->stock}}" required>
                        <button @if (Auth::check()) onclick="achat({{ $product->id}},'{{ $product->name}}',{{ $product->price}},{{$product->stock}})" @else onclick="viewLogin()" @endif type="submit" class="send">valider</button>
                    </div>
                </form>
                <div class="nb-exemplaire">Il ne reste que {{$product->stock}} exemplaires!</div>
                @if (Auth::check())
                    @if(Auth::user()->admin == 1)
                        <a href="{{ route("modification_fiche_product", [$product->id]) }}"><button> Modifier la fiche produit</button></a>
                    @endif
                @endif
            </div>
        </div>
    </h1>
@endsection
