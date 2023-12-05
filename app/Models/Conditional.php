<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditional extends Model
{
    use HasFactory;

    public function conditional_fields(){
        return $this->hasMany(Conditional_field::class);
    }
}
