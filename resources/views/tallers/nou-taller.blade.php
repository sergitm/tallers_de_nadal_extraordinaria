@extends('layouts.form')

@section('title', 'Nou Taller')
@section('form-title', 'Proposa un nou taller')

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
    <form method="POST" action="{{route('taller.store')}}">
        @csrf
        @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
        <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Actiu:</label>
        <div class="form-check form-switch">
            @if(old('actiu') == 'on')
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="actiu" checked>
            @else
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="actiu">
            @endif
        </div>
        @endif
        <div class="form-group my-3">
            <label class="fw-bold" for="nom">Nom:</label>
            <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" value="{{old('nom')}}">
            {!!$errors->first('nom','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="proposat">Proposat per:</label>
            <input type="text" class="form-control" name="proposat" value="{{$nou_taller->creador}}" readonly>
        </div>

        @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
        <div class="form-group my-3">
            <label for="encarregat" class="form-label fw-bold">Encarregat:</label>
            <input type="email" class="form-control @error('encarregat') is-invalid @enderror" list="encarr" id="encarregat" name="encarregat" value="{{old('encarregat')}}" placeholder="Busca un encarregat">
            {!!$errors->first('encarregat','<small class="text-danger">:message</small>')!!}
            <datalist id="encarr">
                @forelse($usuaris as $usuari)
                <option value="{{$usuari->email}}">
                    @empty
                    @endforelse
            </datalist>
        </div>
        <div class="form-group my-3">
            <label for="ajudants" class="form-label fw-bold">Ajudants:</label>
            <input type="email" class="form-control @error('ajudants') is-invalid @enderror" list="ajud" id="ajudants" name="ajudants" value="{{old('ajudants')}}" placeholder="Busca un ajudant" multiple>
            {!!$errors->first('ajudants','<small class="text-danger">:message</small>')!!}
            <datalist id="ajud">
                @forelse($usuaris as $usuari)
                <option value="{{$usuari->email}}">
                    @empty
                    @endforelse
            </datalist>
        </div>
        @endif

        <div class="form-group my-3">
            <label class="fw-bold" for="descripcio">Descripció:</label>
            <textarea class="form-control  @error('descripcio') is-invalid @enderror" name="descripcio" rows=4>{{old('descripcio')}}</textarea>
            {!!$errors->first('descripcio','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="material">Material:</label>
            <textarea class="form-control  @error('material') is-invalid @enderror" name="material">{{old('material')}}</textarea>
            {!!$errors->first('material','<small class="text-danger">:message</small>')!!}
        </div>

        @if(Auth::check() && (Auth::user()->admin || Auth::user()->superadmin))
        <div class="form-group my-3">
            <label class="fw-bold" for="aula">Aula:</label>
            <input type="text" class="form-control @error('aula') is-invalid @enderror" name="aula" value="{{old('aula')}}">
            {!!$errors->first('aula','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="max_participants">Màxim de participants:</label>
            <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror" min=2 max=20 value="{{old('max_participants')}}">
            {!!$errors->first('max_participants','<small class="text-danger">:message</small>')!!}
        </div>
        @endif

        <div class="form-group my-3">
            <label class="fw-bold" for="observacions">Observacions:</label>
            <textarea class="form-control" name="observacions" rows="3">{{old('observacions')}}</textarea>
        </div>
        <div class="form-group my-3">
        <label class="fw-bold">Adreçat a:</label>
            <div class="form-check">
                @if(old('adresat') && in_array('1-ESO', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-ESO" id="1-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-ESO" id="1-ESO">
                @endif
                <label class="form-check-label" for="1-ESO">
                    1er ESO
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('2-ESO', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-ESO" id="2-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-ESO" id="2-ESO">
                @endif
                <label class="form-check-label" for="2-ESO">
                    2n ESO
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('3-ESO', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="3-ESO" id="3-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="3-ESO" id="3-ESO">
                @endif
                <label class="form-check-label" for="3-ESO">
                    3er ESO
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('4-ESO', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="4-ESO" id="4-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="4-ESO" id="4-ESO">
                @endif
                <label class="form-check-label" for="4-ESO">
                    4rt ESO
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('1-FPB', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPB" id="1-FPB" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPB" id="1-FPB">
                @endif
                <label class="form-check-label" for="1-FPB">
                    1er FPB
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('2-FPB', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPB" id="2-FPB" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPB" id="2-FPB">
                @endif
                <label class="form-check-label" for="2-FPB">
                    2n FPB
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('1-BAT', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-BAT" id="1-BAT" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-BAT" id="1-BAT">
                @endif
                <label class="form-check-label" for="1-BAT">
                    1er BAT
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('2-BAT', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-BAT" id="2-BAT" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-BAT" id="2-BAT">
                @endif
                <label class="form-check-label" for="2-BAT">
                    2n BAT
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('1-FPS', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPS" id="1-FPS" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPS" id="1-FPS">
                @endif
                <label class="form-check-label" for="1-FPS">
                    1er FPS
                </label>
            </div>
            <div class="form-check">
                @if(old('adresat') && in_array('2-FPS', old('adresat')))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPS" id="2-FPS" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPS" id="2-FPS">
                @endif
                <label class="form-check-label" for="2-FPS">
                    2n FPS
                </label>
            </div>
        </div>
        <div class="container d-flex justify-content-between">
            <a class="btn btn-dark align-self-center mb-3" href="{{route('home')}}">Tornar</a>
            <input type="submit" class="btn btn-success mb-3" value="Enviar">
        </div>
    </form>
</div>
@endsection