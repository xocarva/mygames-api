<?php

namespace App\Models;

use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    use HasFactory, ModelHelpers;

    const TABLE = 'platforms';

    protected $table = self::TABLE;

    protected $fillable = [
        'name'
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class, 'platform_id');
    }
}
