<?php

namespace App\Traits;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasGenre
{
    public function genre(): Genre
    {
        return $this->genreRelation;
    }

    public function genreRelation(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function isItsGenre(Genre $genre): bool
    {
        return $this->genre()->matches($genre);
    }

    public function belongsToGenre(Genre $genre)
    {
        return $this->genreRelation()->associate($genre);
    }
}