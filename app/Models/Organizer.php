<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'description',
        'logo',
    ];

    /**
     * Получить события, организованные данным организатором.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
