<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;
Use App\User;

class Aplication extends Model
{
  protected $fillable = [
      'name', 'filename', 'isvalid','user_id'
  ];
  
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
