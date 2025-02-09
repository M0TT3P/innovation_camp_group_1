<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicAnalytics extends Model
{
    use HasFactory;

    /**
     * Die Tabelle, die vom Model verwendet wird.
     *
     * @var string
     */
    protected $table = 'chemic_analytics';

    /**
     * Die Attribute, die massenweise zuweisbar sind.
     *
     * @var array
     */
    protected $fillable = [
        'see_id',
        'datum',
        'wetter',
        'sonderzustand',
        'temperatur',
        'sauerstoffgehalt',
        'ph',
        'el',
        'ung_stoffe',
        'ammonium',
        'nitrit',
        'nitrat',
        'ortho_p',
        'gesamt_p',
        'np_verhaltnis',
        'doc',
        'chlorid',
        'chlorophyll',
    ];

    public function see()
    {
        return $this->belongsTo(See::class, 'see_id');
    }
}
