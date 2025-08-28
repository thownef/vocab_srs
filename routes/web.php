<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyController;

Route::get('/', function () {
    return redirect()->route('vocabulary.index');
});

// Special routes
Route::get('/vocabulary/today', [VocabularyController::class, 'todayReviews'])->name('vocabulary.today-reviews');
Route::post('/vocabulary/{word}/review', [VocabularyController::class, 'markAsReviewed'])->name('vocabulary.review');
Route::get('/vocabulary/all', [VocabularyController::class, 'allWords'])->name('vocabulary.all-words');
Route::resource('vocabulary', VocabularyController::class)->except(['show', 'create']);