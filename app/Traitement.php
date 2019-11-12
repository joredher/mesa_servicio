<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    protected $table = "traitements";

    protected $fillable = [
        'description',
        'duree',
        'user_id',
        'ticket_id',
    ];

    public function technicien()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function files()
    {
        return $this->hasMany(UploadFile::class, 'ticket_id');
    }
}
