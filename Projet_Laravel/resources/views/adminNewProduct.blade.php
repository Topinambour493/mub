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
        <form action="{{ route('addProduct') }}" method=POST enctype="multipart/form-data">
            @csrf

            <h2>Ajout Produit</h2>
            <label for="name">Nom produit:</label>
            <input type="text" id="name" name="name" required><br/><br/>
            <label for="price">Prix:</label>
            <input type="number" id="price" name="price" min="0" required><br/><br/>
            <label for="description">Description:</label>
            <textarea rows="5" id="description" name="description" required></textarea><br/><br/>
            <label for="image">Image produit:</label>
            <input type="file" name="image" accept="image/*" required><br/><br/>
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" min="0" required><br/><br/>
            <button type="submit" class="send">valider</button>
        </form>
    </div>
@endsection
