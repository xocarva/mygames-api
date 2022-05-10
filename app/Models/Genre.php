<?php

namespace App\Models;

use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory, ModelHelpers;

    const TABLE = 'genres';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'genre_id');
    }

}
