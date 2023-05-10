<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taller;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuari extends Model
{
    use HasFactory;
    protected $table = 'usuaris';

    public function tallers_proposats() : HasMany {
        return $this->hasMany(Taller::class, 'creador');
    }

    public function tallers_encarregat() : HasOne {
        return $this->hasOne(Taller::class, 'encarregat');
    }

    public function tallers_que_participa() : BelongsToMany {
        return $this->belongsToMany(Taller::class)->as('tallersParticipa')->wherePivot('ajudant', 0)->withTimestamps();
    }

    public function tallers_que_ajuda() : BelongsToMany {
        return $this->belongsToMany(Taller::class)->as('tallersAjuda')->wherePivot('ajudant', 1)->withTimestamps();
    }
    
    public function tallers_primera_opcio() : BelongsToMany {
        return $this->belongsToMany(Taller::class)->as('tallersOpcio1')->wherePivot('prioritat', 1)->withTimestamps();
    }

    public function tallers_segona_opcio() : BelongsToMany {
        return $this->belongsToMany(Taller::class)->as('tallersOpcio2')->wherePivot('prioritat', 2)->withTimestamps();
    }

    public function tallers_tercera_opcio() : BelongsToMany {
        return $this->belongsToMany(Taller::class)->as('tallersOpcio3')->wherePivot('prioritat', 3)->withTimestamps();
    }
}
