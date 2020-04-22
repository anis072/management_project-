<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $appends = ["open"];
	public function getOpenAttribute(){
		return true;
    }
    public function project(){
        return $this->belongsTo(Projet::Class);
    }
    public function user(){
        return $this->belongsTo(User::Class);
    }
    public function comments(){
        return $this->morphMany('App\Commentaire','commentable')->latest();
    }
}
