<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuari;

class AdministracioController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check() && Auth::user()->superadmin) {
            $professors = Usuari::where('categoria', 'professor')->get();
            return view('administracio', compact('professors'));
        }
        abort(403, "Què fas tu aquí?");
    }

    /**
     * Donar permisos d'administració
     */
    public function fer_admin(Request $request)
    {
        // Comprovem que qui entra està logat i té permisos, si no abortem
        if (Auth::check() && Auth::user()->superadmin) {

            // Intentem actualitzar els permisos, si falla retornem amb un missatge
            try {
                // Agafem tots els administradors i primer treiem permisos
                $admins = Usuari::where('admin', 1)->get();
                foreach ($admins as $admin) {
                    $admin->admin = false;
                    $admin->save();
                }
                // Després li donem permisos a qui hagi escollit l'admin
                if (!empty($request->admin)) {
                    foreach ($request->admin as $id) {
                        $professor = Usuari::find($id);
                        $professor->admin = true;
                        $professor->save();
                    }
                }
                $success = true;
            } catch (\Throwable $th) {
                $success = false;
            }
            // Redireccionem en funció de si ha anat bé o no
            if ($success) {
                return redirect()->back()->with('success', 'Permisos actualitzats correctament.');
            } else {
                return redirect()->back()->with('error', 'No s\'han pogut actualitzar els permisos.');
            }
        }
        // Abort
        abort(403, "Què fas aquí");
    }
}
