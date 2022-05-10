<?php

namespace App\Traits;

use App\Models\Game;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasGame
{
    public function game(): Game
    {
        return $this->gameRelation;
    }

    public function gameRelation(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function isCopyOf(Game $game): bool
    {
        return $this->game()->matches($game);
    }

    public function copyOf(Game $game)
    {
        return $this->gameRelation()->associate($game);
    }
}
