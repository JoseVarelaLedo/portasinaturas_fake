<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emenda extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function solicitude():BelongsTo
    {
        return $this->belongsTo(Solicitude::class, 'id_solicitude');
    }

    public function remesas():HasMany
    {
        return $this->hasMany(Remesa::class, 'id_emenda');
    }
}
