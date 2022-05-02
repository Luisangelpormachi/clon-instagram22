<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //asignar tabla
    protected $table = 'images';

    //-- Asignar relaciones --// 

    //relacion de uno a muchos / one to many
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //relaciones de uno a muchos / one to many
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    //relaciones de muchos a uno / many to one
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
