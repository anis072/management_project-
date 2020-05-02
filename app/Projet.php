<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;
use App\User;
use App\Commentaire;
class Projet extends Model
{
    //
    public function client()
    {
        return $this->belongsTo(Client::class , 'client_id');
    }
    protected $fillable = [
        'name', 'duration', 'description','budget','client','owner','namec','membre'
    ];
    protected $table = 'projets';
    public function comments(){
        return $this->morphMany('App\Commentaire','commentable')->latest();
    }
    public function users()
    {
        return $this->belongsToMany('App\User')->using('App\ProjetUser')->withPivot([
        'user_id',
        'projet_id',
    ]);
}
}
