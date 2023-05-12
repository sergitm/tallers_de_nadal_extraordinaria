<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
     
</head>

<body class="bg-secondary">

    @section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              @if(Route::current()->getName() === 'taller.index')
                <a class="nav-link active" aria-current="page" href="{{route('home')}}">Llista de tallers</a>
              @else
                <a class="nav-link" aria-current="page" href="{{route('home')}}">Llista de tallers</a>
              @endif

              @if(Auth::check())
                @if(Route::current()->getName() === 'taller.create')
                  <a class="nav-link active" href="{{route('taller.create')}}">Nou Taller</a>
                @else
                  <a class="nav-link" href="{{route('taller.create')}}">Nou Taller</a>
                @endif
              @endif

              @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
                @if(Route::current()->getName() === 'informes')
                  <a class="nav-link active" href="{{route('informes')}}">Informes</a>
                @else
                  <a class="nav-link" href="{{route('informes')}}">Informes</a>
                @endif
              @endif

              @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
                @if(Route::current()->getName() === 'llista_alumnes')
                  <a class="nav-link active" href="{{route('llista_alumnes')}}">Alumnes del Centre</a>
                @else
                  <a class="nav-link" href="{{route('llista_alumnes')}}">Alumnes del Centre</a>
                @endif
              @endif

              @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
                @if(Route::current()->getName() === 'administracio')
                  <a class="nav-link active" href="{{route('administracio')}}">Administracio</a>
                @else
                  <a class="nav-link" href="{{route('administracio')}}">Administracio</a>
                @endif
              @endif

            </div>
          </div>
          <div class="ml-auto">
            <div class="navbar-nav">
              @if(Auth::check())
                <span class="text-white nav-link">Hola, {{Auth::user()->nom}} |</span><a class="nav-link" href="{{route('login')}}">Logout</a>
              @else  
                @if (Route::current()->getName() === 'login')
                <a class="nav-link active" href="{{route('login')}}">Login</a>
                @else
                <a class="nav-link" href="{{route('login')}}">Login</a>
                @endif
              @endif
            </div>
          </div>
        </div>
      </nav>
    @show

    <div class="container"> 
        @yield('content')
    </div>
    
</body>

</html>