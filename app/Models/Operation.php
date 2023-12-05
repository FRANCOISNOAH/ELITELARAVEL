<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'profils', 'operators', 'user_id','form_id'
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'operation_users');
    }

}
