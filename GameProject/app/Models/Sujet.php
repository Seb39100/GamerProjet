<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    public function commentaires()
     {
     	return $this->hasMany('App\Models\Commentaire');
     }
    
    public function jeus()
     {
     	return $this->belongsTo('App\Models\Jeu');
     }

    public function users()
     {
     	return $this->belongsTo('App\User');
     }
}
