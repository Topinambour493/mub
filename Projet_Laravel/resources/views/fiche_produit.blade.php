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
                <img src="/disk_de_merde/{{$produit->image}}" alt="{{$produit->nom}}" class="contain">
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
                        <input type="number" id="quantité" name="quantité" value="1" min="1" max="{{$produit->stock}}">
                        <button @if (Auth::check()) onclick="achat({{ $produit->id}},'{{ $produit->nom}}',{{ $produit->prix}},{{$produit->stock}})" @else onclick="viewLogin()" @endif type="submit" class="envoie">valider</button>
                    </div>
                </form>
                <div class="nb-exemplaire">Il ne reste que {{$produit->stock}} exemplaires!</div>
            </div>
        </div>
        @if (Auth::check())
            @if(Auth::user()->admin == 1)
                <div class="formulaire">
                    @if ($errors->any())
                        <div class="alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <form class="changeproduit" action="{{ route('changementProduit') }}" method=POST enctype="multipart/form-data">
                        @csrf
                        <h4 class="element">Changement produit</h4><br/>
                        <input type="hidden" name="produit_id" value="{{$produit->id}}">
                        <div class="element">
                            <label for="nom">Nom produit:</label>
                            <input type="text" id="nom" name="nom" value="{{$produit->nom}}">
                        </div>
                        <div class="element">
                            <label for="prix">Prix:</label>
                            <input type="number" id="prix" name="prix" value="{{$produit->prix}}" min="0">
                        </div>
                        <div class="element">
                            <label for="description">Description:</label>
                            <textarea rows="5" id="description" name="description">{{$produit->description}}</textarea>
                        </div>
                        <div class="element">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" name="stock" value="{{$produit->stock}}" min="0">
                        </div>
                        <button class="envoie" type="submit">valider</button>
                    </form>
                </div>
            @endif
        @endif
    </h1>
@endsection
