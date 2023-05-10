@extends('layouts.form')

@section('title', 'Nou Alumne')
@section('form-title', 'Afegeix manualment un alumne que no es troba al SAGA')

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
    <form method="POST" action="{{route('create_alumne')}}">
        @csrf
        <div class="form-group my-3">
            <label class="fw-bold" for="nom">Nom:</label>
            <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" value="{{old('nom')}}">
            {!!$errors->first('nom','<small class="text-danger">:message</small>')!!}
        </div>
        
        <div class="form-group my-3">
            <label class="fw-bold" for="cognoms">Cognoms:</label>
            <input type="text" class="form-control  @error('cognoms') is-invalid @enderror" name="cognoms" value="{{old('cognoms')}}">
            {!!$errors->first('cognoms','<small class="text-danger">:message</small>')!!}
        </div>

        <div class="form-group my-3">
            <label class="fw-bold">A quin curs pertany:</label>
            <select class="form-select form-control  @error('curs') is-invalid @enderror" aria-label="Default select example" name="curs">
                <option value="0" selected>Escull a quina classe va:</option>
                @forelse($combobox as $etapa=>$cursos)
                    @forelse($cursos as $curs=>$classe)
                        @forelse($classe as $grup)
                            <option value="{{$etapa}}-{{$curs}}-{{$grup}}">{{$etapa}} {{$curs}} {{$grup}}</option>
                        @empty
                        @endforelse
                    @empty
                    @endforelse
                @empty
                @endforelse
            </select>
            {!!$errors->first('curs','<small class="text-danger">:message</small>')!!}
        </div>

        <div class="container d-flex justify-content-between">
            <a class="btn btn-dark align-self-center mb-3" href="{{route('home')}}">Tornar</a>
            <input type="submit" class="btn btn-success mb-3" value="Enviar">
        </div>
    </form>
</div>

@endsection