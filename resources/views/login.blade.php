@extends('layouts.form')
 
@section('title', 'Login')
@section('form-title', 'Entra amb Google')
 
@section('navbar')
    @parent
@endsection

@section('form-content')
    <div class="container">
        <div class="my-3">
            <p class="text-center">Entra amb la compta de correu de l'institut:</p>
        </div>
        <div class="mx-auto d-flex justify-content-center mb-3">
            <a class="btn btn-lg btn-outline-dark border border-2" href="{{route('redirect')}}"><i class="fa-brands fa-google fa-2xl"></i></a>
        </div>
        <div class="container d-flex justify-content-start">
            <a class="btn btn-dark align-self-center mb-3" href="{{route('home')}}">Tornar</a>
        </div>
    </div>
@endsection