@extends('layouts.form')

@section('title', 'Nou Taller')
@section('form-title', 'Proposa un nou taller')

@section('navbar')
@parent
@endsection

@section('form-content')

<h3 class="text-danger text-center pb-3">
    @if(isset($data_inicial_format))
    No es poden crear tallers fins el dia {{$data_inicial_format}}
    @elseif(isset($data_final_format))
    No es poden crear tallers desde el dia {{$data_final_format}}
    @endif
</h3>
@endsection