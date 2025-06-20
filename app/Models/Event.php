<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'image',
        'status',
        'category_id',
        'location_id',
        'organizer_id',
        'additional_info',
    ];

    /**
     * Атрибуты, которые следует преобразовывать.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        // 'views' => 'integer', // На будущее, если добавим счетчик просмотров
    ];

    /**
     * Получить категорию, к которой относится событие.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Получить место проведения события.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Получить организатора события.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * Проверяет, является ли событие предстоящим
     * 
     * @return bool
     */
    public function isUpcoming()
    {
        // Сначала получаем текущую дату без времени
        $now = Carbon::now()->startOfDay();
        
        // Проверяем, что дата начала события больше или равна текущей дате
        return $this->start_date >= $now;
    }
    
    /**
     * Форматирует дату события для отображения
     * 
     * @return string
     */
    public function formattedDate()
    {
        return $this->start_date->format('d.m.Y H:i');
    }
}
