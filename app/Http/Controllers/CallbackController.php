<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuari;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Socialite::driver('google')->user();
    
        if ($user->user['hd'] === 'sapalomera.cat') {
            # code...
            $usuari_existent = Usuari::where('email', $user->email)->first();
            // Llegin les dades de l'usuari que ens retorna Google, si ja existeix a la base de dades loguen i ja, si no existeix el creem
            if ($usuari_existent) {
                Auth::loginUsingId($usuari_existent->id);
                return redirect()->route('home');
            } else {

                $usuari = new Usuari;
                $usuari->email = $user->email;
                $usuari->nom = $user->user['given_name'];
                $usuari->cognoms = $user->user['family_name'];
                $usuari->categoria = (strpos(explode('@', $user->email)[0], '.')) ? 'alumne' : 'professor';     // Si el correu conté un punt al principi, és un alumne
                $usuari->etapa;
                $usuari->curs;
                $usuari->grup;
                $usuari->admin = false;
                $usuari->superadmin = false;
                
                if($usuari->save()){
                    $auth_user = Usuari::where('email', $user->email)->first();
                    Auth::loginUsingId($auth_user->id);
                    return redirect()->route('home');
                } else {
                    
                }
            }
        }
    }
}
