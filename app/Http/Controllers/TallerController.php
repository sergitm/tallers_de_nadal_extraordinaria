<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuari;

class TallerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tallers = (Auth::check() && (Auth::user()->superadmin ||  Auth::user()->admin))
            ? Taller::all()
            : Taller::where('actiu', 1)->get();

        $tallers_que_participa = (Auth::check() && (Auth::user()->categoria === 'alumne')) ? count(Usuari::find(Auth::user()->id)->tallers_que_participa) : 0;

        $ids_tallers_que_participa = array();

        if (Auth::check()) {
            foreach (Usuari::find(Auth::user()->id)->tallers_que_participa as $taller) {
                array_push($ids_tallers_que_participa, $taller->id);
            }
        }

        return view('tallers/llista-tallers', compact('tallers', 'tallers_que_participa', 'ids_tallers_que_participa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (!Auth::check()) {
            abort(403, "Què fas tu aquí");
        }
        $nou_taller = new Taller;
        $nou_taller->creador = Auth::user()->email;

        $usuaris = Usuari::all();

        return view('tallers/nou-taller', compact('nou_taller', 'usuaris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!Auth::check()) {
            abort(403, "Què fas tu aquí");
        }
        $request->validate(
            [
                'nom' => 'required',
                'descripcio' => 'required',
                'material' => 'required',
                'aula' => 'required_if:actiu,on',
                'encarregat' => 'required_if:actiu,on',
                'ajudants' => 'required_if:actiu,on',
                'max_participants' => ($request->actiu === 'on') ? 'required_if:actiu,on|numeric|min:2|max:20' : 'required_if:actiu,on',
            ],
            [
                'nom.required' => 'El camp nom és obligatori.',
                'descripcio.required' => 'El camp descripció és obligatori.',
                'material.required' => 'El camp material és obligatori.',
                'aula.required_if' => 'Si actives el taller has de especificar l\'aula',
                'encarregat.required_if' => 'Si actives el taller has de posar un encarregat',
                'ajudants.required_if' => 'Si actives el taller has de posar al menys un ajudant',
                'max_participants.required_if' => 'Si actives el taller has de posar el màxim de participants',
                'max_participants.min' => 'El mínim és 2',
                'max_participants.max' => 'El màxim és 20',

            ]
        );

        $taller = new Taller;
        $taller->nom = $request->nom;
        $taller->creador = $request->user()->id;
        $taller->descripcio = $request->descripcio;
        $taller->adreçat = implode(',', $request->adresat);
        $taller->material = $request->material;
        $taller->observacions = $request->observacions;

        $taller->aula = $request->aula;
        $taller->max_participants = $request->max_participants;
        $taller->actiu = ($request->actiu === 'on') ? true : false;

        if ($request->encarregat) {
            $encarregat = Usuari::where('email', $request->encarregat)->first();
            $taller->encarregat = $encarregat->id;
        }

        try {
            $taller->save();

            if ($request->ajudants) {
                foreach (explode(',', $request->ajudants) as $ajudant_input) {
                    $aj = Usuari::where('email', $ajudant_input)->first();
                    $taller->ajudants()->attach($aj, ['ajudant' => 1]);
                }
            }

            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }

        if ($success) {
            return redirect(route('taller.index'))->with('success', 'El taller s\'ha creat correctament.');
        } else {
            return redirect(route('taller.index'))->with('error', 'No s\'ha pogut creat el taller.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if ((Auth::check() && Auth::user()->superadmin) || (Auth::check() && Auth::user()->admin)) {
            $taller = Taller::find($id);
            $cursos = explode(',', $taller->adreçat);
            $usuaris = Usuari::all();
            $emailArr = array();

            if ($taller->ajudants) {
                foreach ($taller->ajudants as $ajudant) {
                    array_push($emailArr, $ajudant->email);
                }
            }

            $ajudants = implode(',', $emailArr);
            return view('tallers.edit', compact(['taller', 'cursos', 'usuaris', 'ajudants']));
        }

        abort(403, 'No tens permís per veure aquest pàgina.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if (!Auth::check() || !Auth::user()->admin || !Auth::user()->superadmin) {
            abort(403, "Què fas tu aquí");
        }
        $request->validate(
            [
                'nom' => 'required',
                'descripcio' => 'required',
                'material' => 'required',
                'aula' => 'required_if:actiu,on',
                'encarregat' => 'required_if:actiu,on',
                'ajudants' => 'required_if:actiu,on',
                'max_participants' => ($request->actiu === 'on') ? 'required_if:actiu,on|numeric|min:2|max:20' : 'required_if:actiu,on',
            ],
            [
                'nom.required' => 'El camp nom és obligatori.',
                'descripcio.required' => 'El camp descripció és obligatori.',
                'material.required' => 'El camp material és obligatori.',
                'aula.required_if' => 'Si actives el taller has de especificar l\'aula',
                'encarregat.required_if' => 'Si actives el taller has de posar un encarregat',
                'ajudants.required_if' => 'Si actives el taller has de posar al menys un ajudant',
                'max_participants.required_if' => 'Si actives el taller has de posar el màxim de participants',
                'max_participants.min' => 'El mínim és 2',
                'max_participants.max' => 'El màxim és 20',

            ]
        );

        $taller = Taller::find($id);

        if ($request->encarregat) {
            $encarregat = Usuari::where('email', $request->encarregat)->first();
            $taller->encarregat = $encarregat->id;
        }

        $taller->nom = $request->nom;
        $taller->descripcio = $request->descripcio;
        $taller->adreçat = implode(',', $request->adresat);
        $taller->material = $request->material;
        $taller->observacions = $request->observacions;
        $taller->aula = $request->aula;
        $taller->max_participants = $request->max_participants;
        $taller->actiu = ($request->actiu === 'on') ? true : false;

        if ($request->ajudants) {
            $llistaAjudants = $taller->ajudants;
            if (count($llistaAjudants) != 0) {
                $taller->ajudants()->detach();
            }
            foreach (explode(',', $request->ajudants) as $ajudant_input) {
                $aj = Usuari::where('email', $ajudant_input)->first();
                $taller->ajudants()->attach($aj, ['ajudant' => 1]);
            }
        }

        try {
            $taller->save();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }

        if ($success) {
            return redirect()->back()->with('success', 'El taller s\'ha actualitzat correctament.');
        } else {
            return redirect()->back()->with('error', 'No s\'ha pogut actualitzar el taller.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if (!Auth::check() || !Auth::user()->admin || !Auth::user()->superadmin) {
            abort(403, "Què fas tu aquí");
        }
        $taller = Taller::find($id);
        try {
            $taller->delete();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }

        if ($success) {
            return redirect(route('taller.index'))->with('success', 'El taller s\'ha esborrat correctament.');
        } else {
            return redirect()->back()->with('error', 'No s\'ha pogut esborrar el taller.');
        }
    }

    /**
     * Apuntar a un alumne a un taller
     */
    public function apuntar(string $id)
    {
        if (!Auth::check()) {
            abort(403, "Què fas tu aquí");
        }

        $usuari = Usuari::find(Auth::user()->id);
        $taller = Taller::find($id);

        if (count($usuari->tallers_que_participa) >= 3) {
            return redirect()->back()->with('error', 'Ja estàs apuntat a 3 tallers.');
        }

        if ($taller->max_participants == count($taller->participants)) {
            return redirect()->back()->with('error', 'Aquest taller ja està ple, parla amb un administrador.');
        }

        try {
            $usuari->tallers_que_participa()->attach($taller);
            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }

        if ($success) {
            return redirect()->back()->with('success', 'T\'has apuntat correctament al taller.');
        } else {
            return redirect()->back()->with('error', 'Hi ha hagut un problema i no has pogut apuntar-te al taller.');
        }
    }

    /**
     * Donar de baixa d'un taller
     */
    public function baixa(string $id){
        if (!Auth::check()) {
            abort(403, "Què fas tu aquí");
        }
        $usuari = Usuari::find(Auth::user()->id);
        $taller = Taller::find($id);

        try {
            $usuari->tallers_que_participa()->detach($taller->id);
            $success = true;
        } catch (\Throwable $th) {
            $success = false;
        }

        if ($success) {
            return redirect()->back()->with('success', 'T\'has donat de baixa correctament del taller.');
        } else {
            return redirect()->back()->with('error', 'Hi ha hagut un problema i no has pogut donar-te de baixa del taller.');
        }
    }
}
