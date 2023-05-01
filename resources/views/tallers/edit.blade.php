@extends('layouts.form')

@section('title', $taller->nom)
@section('form-title', 'Modifica el taller')

@section('navbar')
@parent
@endsection

@section('form-content')
<div class="container">
    @if(session()->has('success') || session()->has('error'))
    <div class="container @if(session()->has('success')) bg-success @endif @if(session()->has('error')) bg-danger @endif">
        <span class="text-center text-white fw-bold">{{session()->get('success') ?? session()->get('error')}}</span>
    </div>
    @endif
    <form method="POST" action="{{route('taller.update', $taller->id)}}">
        {{ method_field('PATCH') }}
        @csrf
        <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Actiu:</label>
        <div class="form-check form-switch">
            @if(old('actiu') == 'on' || $taller->actiu)
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="actiu" checked>
            @else
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="actiu">
            @endif
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="codi">Codi:</label>
            <input type="text" class="form-control" name="codi" value="{{old('id') ?? $taller->id}}" readonly>
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="nom">Nom:</label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{old('nom') ?? $taller->nom}}">
            {!!$errors->first('nom','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="proposat">Proposat per:</label>
            <input type="text" class="form-control" name="proposat" value="{{old('proposat') ?? $taller->getCreador->email}}" readonly>
        </div>
        <div class="form-group my-3">
            <label for="encarregat" class="form-label fw-bold">Encarregat:</label>
            <input type="email" class="form-control" list="encarr" id="encarregat" name="encarregat" value="{{old('encarregat') ?? $taller->getEncarregat?->email}}" placeholder="Busca un encarregat">
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
            <input type="email" class="form-control" list="ajud" id="ajudants" name="ajudants" value="{{old('ajudants') ?? $ajudants}}" placeholder="Busca un ajudant" multiple>
            {!!$errors->first('ajudants','<small class="text-danger">:message</small>')!!}
            <datalist id="ajud">
                @forelse($usuaris as $usuari)
                    <option value="{{$usuari->email}}">
                @empty
                @endforelse
            </datalist>
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="descripcio">Descripció:</label>
            <textarea class="form-control @error('descripcio') is-invalid @enderror" name="descripcio" rows=4>{{old('descripcio') ?? $taller->descripcio}}</textarea>
            {!!$errors->first('descripcio','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="material">Material:</label>
            <textarea class="form-control @error('material') is-invalid @enderror" name="material">{{old('material') ?? $taller->material}}</textarea>
            {!!$errors->first('material','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="aula">Aula:</label>
            <input type="text" class="form-control @error('aula') is-invalid @enderror" name="aula" value="{{old('aula') ?? $taller->aula}}">
            {!!$errors->first('aula','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="max_participants">Màxim de participants:</label>
            <input type="number" name="max_participants" class="form-control" min=2 max=20 value="{{old('max_participants') ?? $taller->max_participants}}">
            {!!$errors->first('max_participants','<small class="text-danger">:message</small>')!!}
        </div>
        <div class="form-group my-3">
            <label class="fw-bold" for="observacions">Observacions:</label>
            <textarea class="form-control @error('observacions') is-invalid @enderror" name="observacions" rows="3">{{old('observacions') ?? $taller->observacions}}</textarea>
        </div>
        <div class="form-group my-3">
            <label class="fw-bold">Adreçat a:</label>
            <div class="form-check">
                @if(in_array('1-ESO', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-ESO" id="1-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-ESO" id="1-ESO">
                @endif
                <label class="form-check-label" for="1-ESO">
                    1er ESO
                </label>
            </div>
            <div class="form-check">
                @if(in_array('2-ESO', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-ESO" id="2-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-ESO" id="2-ESO">
                @endif
                <label class="form-check-label" for="2-ESO">
                    2n ESO
                </label>
            </div>
            <div class="form-check">
                @if(in_array('3-ESO', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="3-ESO" id="3-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="3-ESO" id="3-ESO">
                @endif
                <label class="form-check-label" for="3-ESO">
                    3er ESO
                </label>
            </div>
            <div class="form-check">
                @if(in_array('4-ESO', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="4-ESO" id="4-ESO" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="4-ESO" id="4-ESO">
                @endif
                <label class="form-check-label" for="4-ESO">
                    4rt ESO
                </label>
            </div>
            <div class="form-check">
                @if(in_array('1-FPB', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPB" id="1-FPB" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPB" id="1-FPB">
                @endif
                <label class="form-check-label" for="1-FPB">
                    1er FPB
                </label>
            </div>
            <div class="form-check">
                @if(in_array('2-FPB', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPB" id="2-FPB" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-FPB" id="2-FPB">
                @endif
                <label class="form-check-label" for="2-FPB">
                    2n FPB
                </label>
            </div>
            <div class="form-check">
                @if(in_array('1-BAT', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-BAT" id="1-BAT" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-BAT" id="1-BAT">
                @endif
                <label class="form-check-label" for="1-BAT">
                    1er BAT
                </label>
            </div>
            <div class="form-check">
                @if(in_array('2-BAT', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-BAT" id="2-BAT" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="2-BAT" id="2-BAT">
                @endif
                <label class="form-check-label" for="2-BAT">
                    2n BAT
                </label>
            </div>
            <div class="form-check">
                @if(in_array('1-FPS', $cursos))
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPS" id="1-FPS" checked>
                @else
                <input class="form-check-input" type="checkbox" name="adresat[]" value="1-FPS" id="1-FPS">
                @endif
                <label class="form-check-label" for="1-FPS">
                    1er FPS
                </label>
            </div>
            <div class="form-check">
                @if(in_array('2-FPS', $cursos))
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
            <input type="submit" class="btn btn-success mb-3" value="Enviar">
    </form>

    <form action="{{route('taller.destroy', $taller->id)}}" method="POST">
        {{ method_field('DELETE') }}
        @csrf
        <input type="submit" onclick="return confirm('Estàs segur que vols eliminar el taller?')" class="btn btn-danger mb-3" value="Eliminar">
    </form>
</div>
<div class="container d-flex justify-content-between">
    <a class="btn btn-dark align-self-center mb-3" href="{{route('home')}}">Tornar</a>
</div>
</div>
@endsection