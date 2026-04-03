<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentacionTecnica extends Model
{
    use HasFactory;

    protected $table = 'documentaciones_tecnicas';

    protected $guarded = [];

    public function solicitude(): BelongsTo
    {
        return $this->belongsTo(Solicitude::class);
    }
}
