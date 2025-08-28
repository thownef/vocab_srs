<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewSchedule extends Model
{
    protected $fillable = [
        'vocabulary_word_id',
        'review_date',
        'review_round',
        'is_completed'
    ];

    protected $casts = [
        'review_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function vocabularyWord(): BelongsTo
    {
        return $this->belongsTo(VocabularyWord::class);
    }
}
