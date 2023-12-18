<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Operation extends Model
{
    use HasFactory, HasRoles;

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


    public function usersWithRole($role)
    {
        return $this->users->filter(function ($user) use ($role) {
            return $user->hasRole($role);
        });
    }

}
