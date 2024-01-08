@extends('layout/default')

@section('title')
    MUB inscription
@endsection

@section('css')
    <link rel="stylesheet" href="/css/authentification.css">
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
        <form action="{{ route('registered') }}" method=POST>
            @csrf

            <h2>Inscription</h2>
            <label for="name">Prénom:</label>
            <input type="text" id="name" name="name"><br/><br/>
            <label for="lastname">Nom:</label>
            <input type="text" id="lastname" name="lastname"><br/><br/>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br/><br/>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password"><br/><br/>
            <label for="password_confirmation">Confirmation mot de passe:</label>
            <input type="password" id="password_confirmation" name="password_confirmation"><br/><br/>
            <button type="submit">inscription</button>
        </form>
    </div>
@endsection
