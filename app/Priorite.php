<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priorite extends Model
{
    protected $table = 'priorites';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
