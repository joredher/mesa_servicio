<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadFile extends Model
{
    protected $fillable = ['name_file', 'path', 'ticket_id', 'traitement_id'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['url_path'];

    public function getUrlPathAttribute()
    {
        return Storage::url($this->attributes['path'] . $this->attributes['name_file']);
    }
}
