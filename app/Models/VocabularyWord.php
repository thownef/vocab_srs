<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VocabularyWord extends Model
{
    protected $fillable = [
        'word',
        'part_of_speech',
        'pronunciation',
        'meaning',
        'review_count',
        'next_review_date',
        'created_date',
        'learning_day_number',
    ];

    protected $casts = [
        'part_of_speech' => PartOfSpeech::class,
        'next_review_date' => 'date',
        'created_date' => 'date',
        'learning_day_number' => 'integer',
    ];

    public function reviewSchedules()
    {
        return $this->hasMany(ReviewSchedule::class);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('word', 'like', "%{$term}%")
                ->orWhere('meaning', 'like', "%{$term}%");
        });
    }

    public function scopePartOfSpeech($query, ?string $pos)
    {
        if (!$pos) return $query;
        return $query->where('part_of_speech', $pos);
    }

    public function getPartOfSpeechLabel(): ?string
    {
        return $this->part_of_speech
            ? PartOfSpeech::options()[$this->part_of_speech->value] ?? $this->part_of_speech->value
            : null;
    }
}
