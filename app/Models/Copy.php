<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;

    const TABLE = 'copies';

    protected $table = self::TABLE;

    protected $fillable = [
        'user_id',
        'game_id',
        'platform_id',
        'rating',
        'completed',
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function rating():int
    {
        return $this->rating;
    }

    public function completed(): bool
    {
        return $this->completed;
    }
}
