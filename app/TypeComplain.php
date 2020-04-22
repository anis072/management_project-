<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class TypeComplain extends Model
{
    protected $fillable = [
        'type'
     ];
     protected $table = 'type_complain';
}