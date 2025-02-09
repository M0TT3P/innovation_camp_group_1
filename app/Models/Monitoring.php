<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    /**
     * Die Tabelle, die vom Model verwendet wird.
     *
     * @var string
     */
    protected $table = 'monitoring';

    /**
     * Die Attribute, die massenweise zuweisbar sind.
     *
     * @var array
     */
    protected $fillable = [
        'see_id',
        'datum',
        'pegelstand',
        'verdunstung',
        'niederschlag',
        'temperatur'
    ];

    public function see()
    {
        return $this->belongsTo(See::class, 'see_id');
    }
}
