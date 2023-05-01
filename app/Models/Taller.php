<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuari;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Taller extends Model
{
    use HasFactory;
    protected $table = 'tallers';

    public function getCreador() : BelongsTo {
        return $this->belongsTo(Usuari::class, 'creador', 'id');
    }

    public function getEncarregat() : BelongsTo {
        return $this->belongsTo(Usuari::class, 'encarregat', 'id');
    }

    public function participants() : BelongsToMany {
        return $this->belongsToMany(Usuari::class)->as('participants')->wherePivot('ajudant', 0)->withTimestamps();
    }

    public function ajudants() : BelongsToMany {
        return $this->belongsToMany(Usuari::class)->as('ajudants')->wherePivot('ajudant', 1)->withTimestamps();
    }
}
