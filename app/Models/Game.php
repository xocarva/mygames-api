<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

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

}
