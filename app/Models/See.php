<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class See extends Model
{
    use HasFactory;

    /**
     * Die Tabelle, die vom Model verwendet wird.
     *
     * @var string
     */
    protected $table = 'seen';

    /**
     * Die Attribute, die massenweise zuweisbar sind.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
