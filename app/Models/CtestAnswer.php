<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtestAnswer extends Model
{
    use HasFactory;

    protected $table = 'ctest_answers';

    public function session(){
        return $this->belongsTo(Session::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ctest(){
        return $this->belongsTo(Ctest::class);
    }

}
