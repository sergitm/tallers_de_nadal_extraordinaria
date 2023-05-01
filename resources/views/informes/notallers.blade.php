@extends('layouts.list')

@section('title', 'Informes')
@section('content-title', 'Informes')

@section('navbar')
@parent
@endsection

@section('list-title', 'Alumnes sense taller')
@section('list-content')
    @if(count($array_alumnes) > 0)
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Alumne</th>
      <th scope="col">Número de tallers als que s'ha apuntat</th>
    </tr>
  </thead>
  <tbody>
    @forelse($array_alumnes as $key=>$alumne)
    <tr>
      <th scope="row">{{++$key}}</th>
      <td>{{$alumne->nom}} {{$alumne->cognoms}}</td>
      <td>{{$alumne->tallers_que_participa_count}}</td>
    </tr>
    @empty
    @endforelse
  </tbody>
</table>
    @else
    <p class="text-center fw-bold">No hi ha cap alumne sense tallers.</p>
    @endif
@endsection