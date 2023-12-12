@extends('layout/default')

@section('title')
MUB Admin
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
<div class="form">
    @if ($errors->any())
    <div class="alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    @endif
    <form class="changeproduit" action="{{ route('changeProduct') }}" method=POST enctype="multipart/form-data">
        @csrf
        <h4 class="element">Changement produit</h4><br/>
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <div class="element">
            <label for="name">Nom produit:</label>
            <input type="text" id="name" name="name" value="{{$product->name}}" required>
        </div>
        <div class="element">
            <label for="price">Prix:</label>
            <input type="number" id="price" name="price" value="{{$product->price}}" min="0" required>
        </div>
        <div class="element">
            <label for="description">Description:</label>
            <textarea rows="5" id="description" name="description" required>{{$product->description}}</textarea>
        </div>
        <div class="element image">
            <label for="image">Image produit:</label>
            <div class="element">
                <img src="/disk_products/{{$product->image}}" alt="{{$product->name}}" class="picto-contain">
            </div>
            <div>Si vous ne chargez pas de nouvelle image, celle-ci reste par défaut</div>
            <input type="file" name="image" accept="image/*"><br/><br/>
        </div>
        <div class="element">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="{{$product->stock}}" min="0" required>
        </div>
        <button class="send" type="submit">valider</button>
    </form>
</div>
@endsection