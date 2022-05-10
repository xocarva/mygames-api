<?php

namespace App\Traits;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasPlatform
{
    public function platform(): Platform
    {
        return $this->platformRelation;
    }

    public function platformRelation(): BelongsTo
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function isFromPlatform(Platform $platform): bool
    {
        return $this->platform()->matches($platform);
    }

    public function fromPlatform(Platform $platform)
    {
        return $this->platformRelation()->associate($platform);
    }
}