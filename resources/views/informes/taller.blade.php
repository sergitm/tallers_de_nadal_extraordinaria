@extends('layouts.list')

@section('title', 'Informes')
@section('content-title', 'Informes')

@section('navbar')
@parent
@endsection

@section('list-title', 'Tallers escollits pels alumnes')
@section('list-content')
<div class="container d-flex justify-content-around m-3">
    <h3 class="text-center"><strong>TALLER {{$taller->id}}:</strong> {{$taller->nom}}</h3>
    <h3 class="text-center"><strong>AULA/ESPAI:</strong> {{$taller->aula}}</h3>
</div>

<table class="table table-striped m-3">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Persona</th>
            <th scope="col">Encarregat</th>
            <th scope="col">Ajudants</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">0</th>
            <td>{{$taller->getEncarregat?->cognoms}}, {{$taller->getEncarregat?->nom}}</td>
            <td>Si</td>
            <td>No</td>
        </tr>
        @forelse($taller->ajudants as $key=>$alumne)
        <tr>
            <th scope="row">{{++$key}}</th>
            <td>{{$alumne->cognoms}}, {{$alumne->nom}}</td>
            @if($taller->getEncarregat?->id == $alumne->id)
            <td>Si</td>
            @else
            <td>No</td>
            @endif
            <td>Si</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>

@if(count($taller->participants) > 0)
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Alumnat</th>
            <th scope="col">Curs/Grup</th>
        </tr>
    </thead>
    <tbody>
        @forelse($taller->participants as $key=>$alumne)
        <tr>
            <th scope="row">{{++$key}}</th>
            <td>{{$alumne->cognoms}}, {{$alumne->nom}}</td>
            <td>{{$alumne->curs}} {{$alumne->etapa}} {{$alumne->grup}}</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
@else
<p class="text-center fw-bold">No hi han alumnes inscrits.</p>
@endif
@endsection