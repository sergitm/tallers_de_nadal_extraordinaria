@extends('layouts.layout')

@section('content')
<div class="container my-3 rounded-5">
    <h1 class="text-center">@yield('content-title')</h1>
    <div class="shadow-lg bg-light rounded rounded-5 pt-2">
        <h2 class="fw-bold text-center">@yield('list-title')</h2>
        <hr class="border-3 border-top border-dark">
        <div class="container pb-2">
            <div class="accordion m-4" id="accordionPanelsStayOpenExample">
            @yield('list-content')
            </div>
        </div>
    </div>
</div>
@endsection