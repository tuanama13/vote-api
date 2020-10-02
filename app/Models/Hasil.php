<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tbhasil';
    protected $fillable = [
        'jumlah'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
