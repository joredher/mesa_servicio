<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesUser extends Model
{
    protected $table = 'categories_users';

    protected $fillable = ['categorie_id', 'user_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function categorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
