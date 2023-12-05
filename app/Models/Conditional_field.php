<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditional_field extends Model
{
    use HasFactory;

    public function conditionals(){
        return $this->belongsTo(Conditional::class);
    }
}
