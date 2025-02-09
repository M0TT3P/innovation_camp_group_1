<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluidManagment extends Model
{
    use HasFactory;

    protected $table = 'fluid_managment'; // Falls der Tabellenname vom Standard abweicht

    protected $fillable = [
        'see_id',
        'type',
        'comming_from',
        'going_too',
        'reason',
        'started_drain',
        'ended_drain',
        'menge',
        'datum',
        'pegelstand_vor',
        'pegelstand_nach',
    ];

    // Falls eine Beziehung zu einem anderen Modell (z.B. "Seen") besteht
    public function see()
    {
        return $this->belongsTo(See::class, 'see_id');
    }
}
