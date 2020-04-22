<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class ProjetUser extends Pivot
{
    //
    public $table = 'projet_user';
    protected $fillable = [
        'id','projet_id' , 'user_id','membre','role'
      ];
}
