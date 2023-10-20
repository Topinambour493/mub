@extends('layout/default')


@section('title')
    MUB catalogue
@endsection

@section('css')
<link rel="stylesheet" href="/css/catalogue.css">
@endsection

@section('content')
    <div class="content">
        <div class="message">
            @if ($message = Session::get('success'))
                <p>{{ $message }}</p>
            @endif
        </div>
        <div class="container">
            @foreach ($produits as $produit)
                <div class="bloc">
                    <div class="centre"><a href="{{ route('fiche_produit', [$produit->id]) }}) }}"><img src="/disk_de_merde/{{$produit->image}}" alt="{{$produit->nom}}" class="contain"></a></br></div>
                    <div class="centre">{{$produit->nom}}</br></div>
                    <div class="centre">
                        <a href="{{ route('fiche_produit', [$produit->id]) }}"><button>voir +</button></a>
                        <form onsubmit="return false">
                            @csrf
                            <button @if (Auth::check()) onclick="achatDirect({{ $produit->id}},'{{ $produit->nom}}',{{ $produit->prix}},{{ $produit->stock}})" @else onclick="viewLogin()" @endif >Achat Direct</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
