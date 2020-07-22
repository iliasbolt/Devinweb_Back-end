<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cities;

class Partners extends Model
{
    protected $table = "partners";

    public function Cities()
    {
        return $this->belongsTo('App\Cities');
    }



}
