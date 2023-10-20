@extends('layout/default')

@section('title')
    MUB renitialisation
@endsection

@section('css')
    <link rel="stylesheet" href="/css/authentification.css">
@endsection

@section('content')
    <div class="formulaire">
        <form action="{{route ('connexion')}}" method="GET">
            <h2>Réinitialisation mot de passe</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br/>
            <input type="submit" value="m'envoyer un mail" class="envoie" >
        </form>
    </div>
@endsection
