<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuari;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;

class InformesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        return view('informes.informes');
    }

    // Gestionem la petició per mostrar informe d'alumnes sense tallers
    public function sense_taller(){

        $usuaris = Usuari::withCount('tallers_que_participa')->get();
        
        $array_alumnes = array();
        foreach ($usuaris as $usuari) {
            if ($usuari->categoria == 'alumne' && $usuari->tallers_que_participa_count < 3) {
                array_push($array_alumnes, $usuari);
            }
        }
        
        return view('informes.notallers', compact('array_alumnes'));
    }

    // Gestionem la petició per mostrar informe del material dels tallers
    public function material_taller(){
        $tallers = Taller::all();
        
        return view('informes.material', compact('tallers'));
    }

    // Gestionem la petició per mostrar informe dels tallers escollits pels alumnes
    public function tallers_escollits(){
        $usuaris = Usuari::withCount('tallers_que_participa')->get();
        
        $alumnes = array();
        foreach ($usuaris as $usuari) {
            if ($usuari->categoria == 'alumne' && $usuari->tallers_que_participa_count === 3) {
                array_push($alumnes, $usuari);
            }
        }
        
        return view('informes.escollits', compact('alumnes'));
    }

    // Gestionem la petició per mostrar informe dels participants del taller seleccionat
    public function participants(string $id){
        $taller = Taller::find($id);
        
        return view('informes.taller', compact('taller'));
    }
    
}
