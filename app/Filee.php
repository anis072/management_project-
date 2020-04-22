<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filee extends Model
{
    //
      //
      public $table = 'files';
      protected $fillable = [
          'projet_id' , 'file'
        ];
  }