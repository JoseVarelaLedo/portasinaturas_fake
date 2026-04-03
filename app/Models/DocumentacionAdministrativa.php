<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentacionAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'documentaciones_administrativas';

    protected $guarded = [];

    public function solicitude(): BelongsTo
    {
        return $this->belongsTo(Solicitude::class);
    }
}
