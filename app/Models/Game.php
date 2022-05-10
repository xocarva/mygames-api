<?php

namespace App\Models;

use App\Traits\HasGenre;
use App\Traits\HasStudio;
use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory, HasGenre, HasStudio, ModelHelpers;

    const TABLE = 'games';

    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'genre_id',
        'studio_id'
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class, 'game_id');
    }

}
