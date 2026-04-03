<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante');
    }

    public function usuarioAdministrativo(): BelongsTo
    {
        return $this->belongsTo(UsuarioAdministrativo::class, 'id_usuario_admin');
    }

    public function usuarioTecnico(): BelongsTo
    {
        return $this->belongsTo(UsuarioTecnico::class, 'id_usuario_tecnico');
    }

    public function entidade(): BelongsTo
    {
        return $this->belongsTo(Entidade::class, 'id_entidade');
    }
    public function documentacionAdministrativa()
    {
        return $this->hasOne(DocumentacionAdministrativa::class);
    }

    public function documentacionTecnica()
    {
        return $this->hasOne(DocumentacionTecnica::class);
    }
}
