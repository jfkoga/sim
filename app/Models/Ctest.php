<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctest extends Model
{
    use HasFactory;

    protected $table = 'ctests';

    public function sessions(){
        return $this->hasMany(Session::class);
    }

    public function ctestanswers(){
        return $this->hasMany(CtestAnswer::class);
    }

}
