<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ReviewSchedule extends Model
{
    protected $collection = 'review_schedules';

    protected $fillable = [
        'vocabulary_word_id',
        'review_date',
        'review_round',
        'is_completed'
    ];

    protected $casts = [
        'review_date' => 'date',
        'is_completed' => 'boolean',
        'review_round' => 'integer',
    ];

    public function vocabularyWord()
    {
        return $this->belongsTo(VocabularyWord::class, 'vocabulary_word_id', '_id');
    }
}
