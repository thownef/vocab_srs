<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyController;

Route::get('/', function () {
    return redirect()->route('vocabulary.create');
});

Route::prefix('vocabulary')->name('vocabulary.')->group(function (): void {
    Route::get('review', [VocabularyController::class, 'review'])->name('review');
    Route::post('mark-group', [VocabularyController::class, 'markGroup'])->name('markGroup');
    Route::post('mark/{vocabulary}', [VocabularyController::class, 'mark'])->name('mark');
    Route::post('mark-forgotten/{vocabulary}', [VocabularyController::class, 'markForgotten'])->name('markForgotten');
});

Route::resource('vocabulary', VocabularyController::class)->except(['show']);