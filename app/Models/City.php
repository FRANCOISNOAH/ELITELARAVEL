<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
