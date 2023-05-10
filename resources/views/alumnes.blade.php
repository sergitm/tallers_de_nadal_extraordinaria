@extends('layouts.list')

@section('title', 'Informes')
@section('content-title', 'Informes')

@section('navbar')
@parent
@endsection

@section('list-title', "Llista d'alumnes del centre")
@section('list-content')
@if(session()->has('success') || session()->has('error'))
<div class="container mb-3 @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
    <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
</div>
@endif
@if(count($usuaris) > 0)
<form method="POST" action="{{route('actualitzar_persones')}}">
    @csrf
    <div class="container d-flex justify-content-between">
        <a class="btn btn-dark mb-4" href="{{route('afegir_alumnes')}}">Afegeix manualment un alumne</a>
        <input type="submit" class="btn btn-dark mb-4" value="Importar">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Persona</th>
                <th scope="col">Email</th>
                <th scope="col">Categoria</th>
                <th scope="col">Curs/Grup</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuaris as $key=>$usuari)
            <tr>
                <th scope="row">{{++$key}}</th>
                <td>{{$usuari->nom}} {{$usuari->cognoms}}</td>
                <td>{{$usuari->email}}</td>
                <td>{{ucfirst($usuari->categoria)}}</td>
                <td>{{$usuari->curs}} {{$usuari->etapa}} {{$usuari->grup}}</td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</form>
@else
<p class="text-center fw-bold">No hi ha cap usuari.</p>
@endif
@endsection