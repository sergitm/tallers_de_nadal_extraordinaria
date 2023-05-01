@extends('layouts.layout')

@section('content')
    <div class="container my-3 bg-light rounded-5 w-50">
        <h1 class="text-center">@yield('form-title')</h1>
        <hr class="border-3 border-top border-dark">
        <div class="form-inline justify-content-center">
            @yield('form-content')
        </div>
    </div>
@endsection