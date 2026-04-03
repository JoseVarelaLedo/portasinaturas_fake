<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Remesa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function emenda():BelongsTo
    {
        return $this->belongsTo(Emenda::class, 'id_emenda');
    }

    public function codigoGrupo(): string
    {
        return $this->remesa_grupo ?: 'REM-' . $this->id;
    }

    public function anchorGrupo(): string
    {
        return 'remesa-' . Str::slug($this->codigoGrupo());
    }
}
