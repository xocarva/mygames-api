<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{
    public function owner(): User
    {
        return $this->ownerRelation;
    }

    public function ownerRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner()->matches($user);
    }

    public function ownedBy(User $user)
    {
        return $this->ownerRelation()->associate($user);
    }
}