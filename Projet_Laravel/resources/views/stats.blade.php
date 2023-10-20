@extends('layout/default')


@section('title')
MUB Stats
@endsection



@section('css')
    <link rel="stylesheet" href="/css/stats.css">
@endsection

@section('content')
    <div class="statistiques">
        <div class="centreage" id="nb_commandes"></div><br><br><br><br>
        <div class="centreage" id="biggestpurchase"></div><br><br><br><br>
        <div class="centreage" id="nb_users"></div><br><br><br><br>        
        <div class="centreage">
            <button onclick="refresh()">refresh</button>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="/js/stats.js"></script>
    <script>refresh()</script>
@endsection
