<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacacion';
    protected $fillable = ['titulo', 'descripcion', 'precio', 'idtipo', 'pais'];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'idtipo');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(Foto::class, 'idvacacion');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'idvacacion');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'idvacacion');
    }
}