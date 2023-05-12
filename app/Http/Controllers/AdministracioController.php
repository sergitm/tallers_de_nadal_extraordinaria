<?php

namespace App\Http\Controllers;

use App\Models\Settings;
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
        if (Auth::check() && (Auth::user()->admin || Auth::user()->superadmin)) {
            $professors = Usuari::where('categoria', 'professor')->get();
            $settings = Settings::where('nom','settings')->first();
            return view('administracio', compact('professors','settings'));
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

    public function config_dates(Request $request)
    {
        $request->validate(
            [
                'creacio_inici' => 'required_with:creacio_final',
                'creacio_final' => 'required_with:creacio_inici|after_or_equal:'.$request->creacio_inici,
                'eleccio_inici' => 'required_with:eleccio_final',
                'eleccio_final' => 'required_with:eleccio_inici|after_or_equal:'.$request->eleccio_inici,
            ],
            [
                'creacio_inici.required_with' => 'El camp data inicial de creació és obligatori si esculls una data final.',
                'creacio_final.required_with' => 'El camp data final de creació és obligatori si esculls una data inicial.',
                'creacio_final.after_or_equal' => 'La data final per crear tallers no pot ser anterior a la inicial.',
                'eleccio_inici.required_with' => 'El camp data inicial d\'elecció és obligatori si esculls una data final.',
                'eleccio_final.required_with' => 'El camp data final d\'elecció és obligatori si esculls una data inicial.',
                'eleccio_final.after_or_equal' => 'La data final per escollir tallers no pot ser anterior a la inicial.',
            ]
        );

        
        try {
            $settings = Settings::where('nom', 'settings')->first();
            if ($request->creacio_inici) {
                $settings->creacio_tallers_data_inicial = $request->creacio_inici;
            }
            if ($request->creacio_final) {
                $settings->creacio_tallers_data_final = $request->creacio_final;
            }
            if ($request->eleccio_inici) {
                $settings->eleccio_tallers_data_inicial = $request->eleccio_inici;
            }
            if ($request->eleccio_final) {
                $settings->eleccio_tallers_data_final = $request->eleccio_final;
            }
            $settings->save();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }
        
        // Redireccionem en funció de si ha anat bé o no
        if ($success) {
            return redirect()->back()->with('success', 'Dades de configuració actualitzades correctament.');
        } else {
            return redirect()->back()->with('error', 'No s\'han pogut actualitzar les dades de configuració.');
        }
    }
}
