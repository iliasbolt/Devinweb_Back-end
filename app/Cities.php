<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Partners;
use App\Delivery_times;

class Cities extends Model
{
    protected $table = "cities";

    public function partner()
    {
        return  $this->hasOne('App\Partners');
    }

    public function delivery_time()
    {
        return $this->belongsToMany(Delivery_times::class);
    }
}
