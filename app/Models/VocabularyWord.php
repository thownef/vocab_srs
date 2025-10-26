<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use MongoDB\Laravel\Eloquent\Model;

class VocabularyWord extends Model
{
    protected $collection = 'vocabulary_words';

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
        'next_review_date' => 'date',
        'created_date' => 'date',
        'learning_day_number' => 'integer',
        'review_count' => 'integer'
    ];

    public function reviewSchedules()
    {
        return $this->hasMany(ReviewSchedule::class, 'vocabulary_word_id', '_id');
    }

    public function scopeFilterBySearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('word', 'regex', "/{$term}/i")
                ->orWhere('meaning', 'regex', "/{$term}/i");
        });
    }

    public function scopePartOfSpeech($query, ?string $pos)
    {
        if (!$pos) return $query;
        return $query->where('part_of_speech', $pos);
    }
}
