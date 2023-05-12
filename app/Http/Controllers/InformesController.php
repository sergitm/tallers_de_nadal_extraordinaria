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
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {
            return view('informes.informes');
        }
        abort(403,"No tens permís per veure informes.");
    }

    // Gestionem la petició per mostrar informe d'alumnes sense tallers
    public function sense_taller(){
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {

            $usuaris = Usuari::withCount('tallers_que_participa')->get();
            
            $array_alumnes = array();
            foreach ($usuaris as $usuari) {
                if ($usuari->categoria == 'alumne' && $usuari->tallers_que_participa_count < 3) {
                    array_push($array_alumnes, $usuari);
                }
            }
            
            return view('informes.notallers', compact('array_alumnes'));
        }
        abort(403, "No tens permís per veure informes.");
    }

    // Gestionem la petició per mostrar informe del material dels tallers
    public function material_taller(){
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {
            $tallers = Taller::all();
            
            return view('informes.material', compact('tallers'));
        }
        abort(403, "No tens permís per veure informes");
    }

    // Gestionem la petició per mostrar informe dels tallers escollits pels alumnes
    public function tallers_escollits(){
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {
            $usuaris = Usuari::withCount('tallers_que_participa')->get();
            
            $alumnes = array();
            foreach ($usuaris as $usuari) {
                if ($usuari->categoria == 'alumne' && $usuari->tallers_que_participa_count === 3) {
                    array_push($alumnes, $usuari);
                }
            }
            
            return view('informes.escollits', compact('alumnes'));
        }
        abort(403, "No tens permís per veure informes.");
    }

    // Gestionem la petició per mostrar informe dels participants del taller seleccionat
    public function participants(string $id){
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {
            $taller = Taller::find($id);
            
            return view('informes.taller', compact('taller'));
        }
        abort(403, "No tens permís per veure informes.");
    }
    
}
