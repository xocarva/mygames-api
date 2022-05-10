<?php

namespace App\Traits;

use App\Models\Studio;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasStudio
{
    public function studio(): Studio
    {
        return $this->studioRelation;
    }

    public function studioRelation(): BelongsTo
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    public function isDevelopedBy(Studio $studio): bool
    {
        return $this->studio()->matches($studio);
    }

    public function developedBy(Studio $studio)
    {
        return $this->studioRelation()->associate($studio);
    }
}