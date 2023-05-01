@extends('layouts.list')

@section('title', 'Administracio')
@section('content-title', 'Administració')

@section('navbar')
@parent
@endsection

@section('list-title', 'Professors i permisos')
@section('list-content')
@if(session()->has('success') || session()->has('error'))
<div class="container @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
    <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
</div>
@endif
@if(count($professors) > 0)
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
@endsection