<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';
    protected $fillable = ['nombre'];

    public function vacaciones(): HasMany
    {
        return $this->hasMany(Vacacion::class, 'idtipo');
    }
}