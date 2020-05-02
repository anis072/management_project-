<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Projet;
class Commentaire extends Model
{
    //
    protected $fillable =['commentable_id','commentable_type','body','projet_id'];
    public function  user(){
        return $this->belongsTo(User::class);
    }
    public function projet(){
        return $this->belongsTo(Projet::class);
    }
    public function commentable(){
           return $this->morphTo();
    }
    public function comments(){
        return $this->morphMany('App\commentaire','commentable')->latest();
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
}
