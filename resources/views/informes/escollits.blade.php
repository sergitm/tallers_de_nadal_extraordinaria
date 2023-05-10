@extends('layouts.list')

@section('title', 'Informes')
@section('content-title', 'Informes')

@section('navbar')
@parent
@endsection

@section('list-title', 'Tallers escollits pels alumnes')
@section('list-content')
    @if(count($alumnes) > 0)
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Alumnat</th>
      <th scope="col">Etapa</th>
      <th scope="col">Curs</th>
      <th scope="col">Grup</th>
      <th scope="col">Taller 1</th>
      <th scope="col">Taller 2</th>
      <th scope="col">Taller 3</th>
    </tr>
  </thead>
  <tbody>
    @forelse($alumnes as $key=>$alumne)
    <tr>
        <th scope="row">{{++$key}}</th>
        <td>{{$alumne->cognoms}}, {{$alumne->nom}}</td>
      <td>{{$alumne->etapa}}</td>
      <td>{{$alumne->curs}}</td>
      <td>{{$alumne->grup}}</td>
      @forelse($alumne->tallers_primera_opcio as $taller)
      <td>{{$taller->id}}-. {{$taller->nom}}</td>
      @empty
      <td></td>
      @endforelse
      @forelse($alumne->tallers_segona_opcio as $taller)
      <td>{{$taller->id}}-. {{$taller->nom}}</td>
      @empty
      <td></td>
      @endforelse
      @forelse($alumne->tallers_tercera_opcio as $taller)
      <td>{{$taller->id}}-. {{$taller->nom}}</td>
      @empty
      <td></td>
      @endforelse
    </tr>
    @empty
    @endforelse
  </tbody>
</table>
    @else
    <p class="text-center fw-bold">No hi han tallers.</p>
    @endif
@endsection