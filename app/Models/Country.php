<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name_fr', 'name_en'];

    /**
     * Relation avec la table user
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function cities(){
        return $this->hasMany(City::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
