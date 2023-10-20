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
        <form action="{{ route('ajoutProduit') }}" method=POST enctype="multipart/form-data">
            @csrf

            <h2>Ajout Produit</h2>
            <label for="nom">Nom produit:</label>
            <input type="text" id="nom" name="nom"><br/><br/>
            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" min="0"><br/><br/>
            <label for="description">Description:</label>
            <textarea rows="5" id="description" name="description"></textarea><br/><br/>
            <label for="catégorie">Catégorie:</label>
            <input type="text" id="catégorie" name="catégorie"><br/><br/>
            <label for="image">Image produit:</label>
            <input type="file" name="image" accept="image/*"><br/><br/>
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" min="0"><br/><br/>
            <button type="submit" class="envoie">valider</button>
        </form>
    </div>
@endsection
