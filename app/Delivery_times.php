<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery_times extends Model
{
    protected $table = "delivery_times";

    public function citie()
    {
        return $this->belongsToMany(Cities::class);
    }

}
