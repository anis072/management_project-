<?php

namespace App;

use  Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
     'id','event_name', 'start_date', 'end_date','user_id'
 ];
 protected $table = 'calendar';
}
