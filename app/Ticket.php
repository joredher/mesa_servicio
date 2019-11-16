<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $table = "tickets";

    protected $fillable = [
        'subject',
        'message',
        'etat',
        'user_id',
        'priorite_id',
        'categorie_id',
        'fecha_consulta',
        'orden',
        'agent_id'
    ];

    protected $appends = ['dias'];

    public function categorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }

    public function priorite()
    {
        return $this->belongsTo(Priorite::class, 'priorite_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function traitements()
    {
        return $this->hasMany(Traitement::class, 'ticket_id');
    }

    public function files()
    {
        return $this->hasMany(UploadFile::class, 'ticket_id');
    }

    /*SCOPE*/

    public function scopePriory($query, $priory)
    {
        if ((trim($priory) !== '' || ! is_null($priory))) {
            $query->where('priorite_id', $priory);
        }
    }

    public function scopeStatus($query, $etat)
    {
        $status = config('options.status');
        $item = ($etat === 1) ? 'Creado' : ($etat === 2 ? 'En curso' : ($etat === 3 ? 'Terminado' : null));
        if ((trim($item) !== '' || ! is_null($item)) && isset($status[$etat])) {
            $query->where('etat', '=', $item);
        }
    }

    /*ACCESOR*/

    public function getDiasAttribute($key)
    {
        $fecha_creacion = Carbon::parse($this->attributes['created_at']);
        $fecha_final = Carbon::parse($this->attributes['updated_at']);
        $fecha_actual = Carbon::now();
        $diffActual = $fecha_creacion->diffInDays($fecha_actual);
        $diffTerminado = $fecha_creacion->diffInDays($fecha_final);

        $estado = $this->attributes['etat'];
        $data = collect();

        if ($estado === 'Terminado' && $this->traitements()->count() >= 1) {
            $data->put('time', $diffTerminado.' día'.($diffTerminado !== 1 ? 's' : ''));
            $data->put('color', "#41B883");
        } else {
            if ($estado === 'En curso' && $this->traitements()->count() >= 1) {
                $respuesta = $this->traitements()->latest()->first()->duree;
                $calculo = (integer) ($respuesta / 60);
                $data->put('time', $calculo .' hr'.($calculo !== 1 ? 's' : ''));
                $data->put('color', "#FFE300");
            } else {
                $data->put('time', $diffActual.' día'.($diffActual !== 1 ? 's' : ''));
                $data->put('color', "#FF4337");
            }
        }

        return $data;
    }
}
