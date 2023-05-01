@extends('layouts.list')

@section('title', 'Informes')
@section('content-title', 'Informes')
@section('navbar')
@parent
@endsection

@section('list-title', 'Escull quin informe vols veure')
@section('list-content')
    <div class="container d-flex justify-content-between my-5">
        <a class="btn btn-lg btn-dark" href="{{route('informes_alumnes_sense_taller')}}">Alumnes sense taller</a>
        <a class="btn btn-lg btn-dark" href="{{route('informes_material_tallers')}}">Material per als tallers</a>
        <a class="btn btn-lg btn-dark" href="{{route('informes_tallers_escollits')}}">Tallers escollits pels alumnes</a>
    </div>
@endsection