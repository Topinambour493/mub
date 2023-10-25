@extends('layout/default')

@section('title')
MUB Admin
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
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
            <input type="text" id="nom" name="nom" value="{{$produit->nom}}" required>
        </div>
        <div class="element">
            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" value="{{$produit->prix}}" min="0" required>
        </div>
        <div class="element">
            <label for="description">Description:</label>
            <textarea rows="5" id="description" name="description" required>{{$produit->description}}</textarea>
        </div>
        <div class="element image">
            <label for="image">Image produit:</label>
            <div class="element">
                <img src="/disk_products/{{$produit->image}}" alt="{{$produit->nom}}" class="picto-contain">
            </div>
            <div>Si vous ne chargez pas de nouvelle image, celle-ci reste par défaut</div>
            <input type="file" name="image" accept="image/*"><br/><br/>
        </div>
        <div class="element">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="{{$produit->stock}}" min="0" required>
        </div>
        <button class="envoie" type="submit">valider</button>
    </form>
</div>
@endsection
