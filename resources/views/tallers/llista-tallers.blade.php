@extends('layouts.list')

@section('title', 'Llista de tallers')
@section('content-title', 'Llista de Tallers')

@section('navbar')
@parent
@endsection

@section('list-title', 'Tallers als que et pots apuntar')
@section('list-content')

@if(Auth::check() && (Auth::user()->categoria === 'alumne'))
<div class="container mb-5">
    <p class="fw-bold @if($tallers_que_participa == 3) text-success @endif">Nombre de tallers als que t'has apuntat: {{$tallers_que_participa}} de 3</p>
</div>
@endif
@if(session()->has('success') || session()->has('error'))
<div class="container mb-3 @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
    <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
</div>
@endif


@forelse($tallers as $taller)
<div class="accordion-item shadow">

    <h2 class="accordion-header" id="taller-{{$taller->id}}-heading">
        <button class="accordion-button text-dark fw-bold @if(Auth::check() && (Auth::user()->superadmin || Auth::user()->admin) && $taller->actiu) bg-success @elseif(Auth::check() && (Auth::user()->superadmin || Auth::user()->admin) && !$taller->actiu) bg-warning @endif" type="button" data-bs-toggle="collapse" data-bs-target="#taller-{{$taller->id}}" aria-expanded="true" aria-controls="taller-{{$taller->id}}">
            {{$taller->nom}}
        </button>
    </h2>

    <div id="taller-{{$taller->id}}" class="accordion-collapse collapse" aria-labelledby="taller-{{$taller->id}}-heading">
        <div class="accordion-body">
            @if($taller->image)
            <div class="row">
                <img class="rounded mx-auto d-block" src="{{asset('storage/images/'.$taller->image)}}" [alt="Imatge del taller {{$taller->nom}}"] />
            </div>
            <hr class="border-3 border-top border-dark">
            @endif
            <div class="row">
                <div class="col"><strong>Nom:</strong> {{$taller->nom}}</div>
                @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
                <div class="col"><strong>Encarregat:</strong> {{$taller->getEncarregat?->email ?? 'Cap'}}</div>
                <div class="col"><strong>Ajudants:</strong> @forelse($taller->ajudants as $ajudant) {{$ajudant->email}} @empty Cap @endforelse</div>
                @endif
                <div class="col"><strong>Adreçat a:</strong> {{$taller->adreçat}}</div>
                <div class="col"><strong>Aula:</strong> {{$taller->aula}}</div>
            </div>
            <hr class="border-3 border-top border-dark">
            <div class="row">
                <div class="col border-end border-3 border-secondary"><strong>Descripcio:</strong></div>
                <div class="col border-end border-3 border-secondary"><strong>Material:</strong></div>
                <div class="col"><strong>Observacions:</strong></div>
            </div>
            <div class="row">
                <div class="col border-end border-3 border-secondary">{{$taller->descripcio}}</div>
                <div class="col border-end border-3 border-secondary">{{$taller->material}}</div>
                <div class="col">{{$taller->observacions}}</div>
            </div>

            @if(Auth::check())
            @if(Auth::user()->admin || Auth::user()->superadmin)
            <div class="mt-2 d-flex justify-content-between">
                <a class="btn btn-info ml" href="{{route('informes_participants', $taller->id)}}">Veure participants</a>
                <a class="btn btn-warning" href="{{route('taller.edit', $taller->id)}}">Veure detalls</a>
            </div>
            @else
            @if(in_array($taller->id, $ids_tallers_que_participa))
            <div class="mt-2 d-flex justify-content-end">
                <a class="btn btn-dark" href="{{route('baixa', $taller->id)}}">Dona't de baixa!</a>
            </div>
                @else
                <div class="m-3 d-flex justify-content-between">
                    <a class="btn btn-dark" href="{{route('apuntar', [$taller->id, 1])}}">Apunta't com a primera opció!</a>
                    <a class="btn btn-dark" href="{{route('apuntar', [$taller->id, 2])}}">Apunta't com a segona opció!</a>
                    <a class="btn btn-dark" href="{{route('apuntar', [$taller->id, 3])}}">Apunta't com a tercera opció!</a>
                </div>
                @endif
            @endif
            @endif
        </div>
    </div>
</div>
@empty
<p class="text-center">No hi han tallers actualment.</p>
@endforelse
@endsection