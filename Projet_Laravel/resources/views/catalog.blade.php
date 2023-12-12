@extends('layout/default')


@section('title')
    MUB catalogue
@endsection

@section('css')
<link rel="stylesheet" href="/css/catalog.css">
@endsection

@section('content')
    <div class="content">
        <div class="message">
            @if ($message = Session::get('success'))
                <p>{{ $message }}</p>
            @endif
        </div>
        <div class="container">
            @foreach ($products as $product)
                <div class="bloc">
                    <div class="centre"><a href="{{ route('productSheet', [$product->id]) }}"><img src="/disk_products/{{$product->image}}" alt="{{$product->name}}" class="contain"></a><br/></div>
                    <div class="centre">{{$product->name}}</br></div>
                    <div class="centre">
                        <a href="{{ route('productSheet', [$product->id]) }}"><button>Détail</button></a>
                        <form onsubmit="return false">
                            @csrf
                            <button @if (Auth::check()) onclick="achatDirect({{ $product->id}},'{{ $product->name}}',{{ $product->price}},{{ $product->stock}})" @else onclick="viewLogin()" @endif >Achat Direct</button>
                        </form>
                        <br/>
                        @if (Auth::check())
                            @if(Auth::user()->admin == 1)
                                <a href="{{ route("modificationProductSheet", [$product->id]) }}"><button> Modifier la fiche produit</button></a>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
