<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyController;

Route::get('/', function () {
    return redirect()->route('vocabulary.index');
});

Route::prefix('vocabulary')->name('vocabulary.')->group(function () {
    Route::get('today', [VocabularyController::class, 'todayReviews'])->name('today-reviews');
    Route::post('review/bulk', [VocabularyController::class, 'markGroupReviewed'])->name('review.bulk');
    Route::post('{vocabulary}/review', [VocabularyController::class, 'markAsReviewed'])->name('review');
    Route::get('all', [VocabularyController::class, 'allWords'])->name('all-words');

});

Route::resource('vocabulary', VocabularyController::class)->except(['show', 'create']);