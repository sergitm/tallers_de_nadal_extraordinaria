@extends('layouts.form')

@section('title', 'Apuntar alumne')
@section('form-title', 'Apunta a l\'alumne a 3 tallers')

@section('navbar')
@parent
@endsection

@section('form-content')

@if(session()->has('success') || session()->has('error'))
<div class="container @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
    <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
</div>
@endif

<div class="container">
    <form method="POST" action="{{route('apuntar_tallers', $alumne)}}">
        @csrf
        <input type="text" class="form-control" name="id_alumne" value="{{$alumne->id}}" hidden>
        <div class="form-group my-3">
            <label class="fw-bold" for="nom">Nom:</label>
            <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" value="{{$alumne->nom}}" disabled>
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="cognoms">Cognoms:</label>
            <input type="text" class="form-control  @error('cognoms') is-invalid @enderror" name="cognoms" value="{{$alumne->cognoms}}" disabled>
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="classe">Classe:</label>
            <input type="text" class="form-control  @error('classe') is-invalid @enderror" name="classe" value="{{$alumne->etapa}} {{$alumne->curs}} {{$alumne->grup}}" disabled>
        </div>

        <div class="form-group my-3">
            <label class="fw-bold">Primera opció:</label>
            <select class="form-select form-control  @error('taller1') is-invalid @enderror" aria-label="Default select example" name="taller1">
                <option value="0" selected>Taller 1</option>
                @forelse($tallers as $taller)
                    <option value="{{$taller->id}}">{{$taller->nom}}</option>
                @empty
                @endforelse
            </select>
            {!!$errors->first('taller1','<small class="text-danger">:message</small>')!!}
        </div>

        <div class="form-group my-3">
            <label class="fw-bold">Segona opció:</label>
            <select class="form-select form-control  @error('taller2') is-invalid @enderror" aria-label="Default select example" name="taller2">
                <option value="0" selected>Taller 2</option>
                @forelse($tallers as $taller)
                    <option value="{{$taller->id}}">{{$taller->nom}}</option>
                @empty
                @endforelse
            </select>
            {!!$errors->first('taller2','<small class="text-danger">:message</small>')!!}
        </div>

        <div class="form-group my-3">
            <label class="fw-bold">Tercera opció:</label>
            <select class="form-select form-control  @error('taller3') is-invalid @enderror" aria-label="Default select example" name="taller3">
                <option value="0" selected>Taller 3</option>
                @forelse($tallers as $taller)
                    <option value="{{$taller->id}}">{{$taller->nom}}</option>
                @empty
                @endforelse
            </select>
            {!!$errors->first('taller3','<small class="text-danger">:message</small>')!!}
        </div>

        <div class="container d-flex justify-content-between">
            <a class="btn btn-dark align-self-center mb-3" href="{{route('home')}}">Tornar</a>
            <input type="submit" class="btn btn-success mb-3" value="Enviar">
        </div>
    </form>
</div>

@endsection