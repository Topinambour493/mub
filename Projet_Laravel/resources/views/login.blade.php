@extends('layout/default')


@section('title')
    MUB connexion
@endsection

@section('css')
    <link rel="stylesheet" href="/css/authentification.css">
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
        <form action="{{ route('authentification') }}" method=POST>
            @csrf

            <h2>Connexion</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br/><br/>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password"><br/><br/>
            <button type="submit">connexion</button><br><br>
            <a href="{{ route('reset') }}">Reinitialiser votre mot de passe</a>
        </form>
    </div>
@endsection
