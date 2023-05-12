@extends('layouts.list')

@section('title', 'Administracio')
@section('content-title', 'Administració')

@section('navbar')
@parent
@endsection

@section('list-title', 'Administració del lloc')
@section('list-content')
@if(session()->has('success') || session()->has('error'))
<div class="container @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
    <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
</div>
@endif

<div class="container">
    <h3 class="text-center fw-bold m-3">Dates per crear i escollir tallers</h3>
    <form method="POST" action="{{route('config')}}">
        @csrf
        <div class="container row d-flex justify-content-center my-4">
            <div class="col-4">
                <label class="form-label fw-bold" for="creacio_inici">Data inicial per crear tallers:</label>
                <input id="creacio_inici" name="creacio_inici" class="form-control @error('creacio_inici') is-invalid @enderror" type="date" value="{{old('creacio_inici') ?? $settings->creacio_tallers_data_inicial}}">
            {!!$errors->first('creacio_inici','<small class="text-danger">:message</small>')!!}
            </div>
            <div class="col-4">
                <label class="form-label fw-bold" for="creacio_final">Data final per crear tallers:</label>
                <input id="creacio_final" name="creacio_final" class="form-control @error('creacio_final') is-invalid @enderror" type="date" value="{{old('creacio_final') ?? $settings->creacio_tallers_data_final}}">
            {!!$errors->first('creacio_final','<small class="text-danger">:message</small>')!!}
            </div>
        </div>
        <div class="container row d-flex justify-content-center my-4">
            <div class="col-4">
                <label class="form-label fw-bold" for="eleccio_inici">Data inicial per escollir tallers:</label>
                <input id="eleccio_inici" name="eleccio_inici" class="form-control @error('eleccio_inici') is-invalid @enderror" type="date" value="{{old('eleccio_inici') ?? $settings->eleccio_tallers_data_inicial}}">
            {!!$errors->first('eleccio_inici','<small class="text-danger">:message</small>')!!}
            </div>
            <div class="col-4">
                <label class="form-label fw-bold" for="eleccio_final">Data final per escollir tallers:</label>
                <input id="eleccio_final" name="eleccio_final" class="form-control @error('eleccio_final') is-invalid @enderror" type="date" value="{{old('eleccio_final') ?? $settings->eleccio_tallers_data_final}}">
            {!!$errors->first('eleccio_final','<small class="text-danger">:message</small>')!!}
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <input class="btn btn-dark" type="submit" >
        </div>
    </form>
</div>

@if(Auth::check() && Auth::user()->superadmin)
    @if(count($professors) > 0)
    <hr class="border-3 border-top border-dark">
    <h2 class="text-center fw-bold m-3">Professors i permisos</h2>
    <form method="POST" action="{{route('fer_admin')}}">
        @csrf
        <div class="container d-flex justify-content-end">
            <input type="submit" class="btn btn-dark mb-4" value="Enviar">
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Professor</th>
                    <th scope="col">Permisos d'administració</th>
                </tr>
            </thead>
            <tbody>
                @forelse($professors as $key=>$professor)
                <tr>
                    <th scope="row">{{++$key}}</th>
                    <td>{{$professor->nom}} {{$professor->cognoms}}</td>
                    <td>
                        <div class="form-check">
                            @if($professor->admin)
                            <input class="form-check-input" type="checkbox" name="admin[]" value="{{$professor->id}}" id="{{$professor->nom}}{{$professor->cognoms}}{{$professor->id}}" checked>
                            @else
                            <input class="form-check-input" type="checkbox" name="admin[]" value="{{$professor->id}}" id="{{$professor->nom}}{{$professor->cognoms}}{{$professor->id}}">
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </form>
    @else
    <p class="text-center fw-bold">No hi ha cap alumne sense tallers.</p>
    @endif
@endif
@endsection