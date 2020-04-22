<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $fillable = [
        'id','type','description','created_at','avancement','projet_id','employe_id','client_id','chef_id'
     ];
     protected $table= 'reclamations';
}
