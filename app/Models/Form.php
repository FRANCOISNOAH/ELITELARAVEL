<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    const STATUS_DRAFT = 'Brouillon';
    const STATUS_PENDING = 'Prêt à ouvrir';
    const STATUS_OPEN = 'Ouvert';
    const STATUS_CLOSED = 'Fermé';

    protected $dates = ['deleted_at'];

    protected $cascadeDeletes = ['fields', 'responses'];

    protected $fillable = [
        'title', 'code', 'status', 'start', 'end','message'
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }

    public function availability()
    {
        return $this->hasOne(FormAvailability::class);
    }

    public function generateCode()
    {
        do {
            $this->code = Str::random(32);
        } while (static::where('code', $this->code)->exists());
    }

    public static function getStatusSymbols()
    {
        return [
            static::STATUS_DRAFT => ['label' => 'Brouillon', 'color' => 'slate'],
            static::STATUS_PENDING => ['label' => 'Prêt à ouvrir', 'color' => 'primary'],
            static::STATUS_OPEN => ['label' => 'Ouvert', 'color' => 'success'],
            static::STATUS_CLOSED => ['label' => 'Fermé', 'color' => 'pink'],
        ];
    }

    public function operation()
    {
        return $this->hasOne(Operation::class);
    }
}
