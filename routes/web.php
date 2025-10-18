<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyCreate;
use App\Http\Controllers\VocabularyEdit;
use App\Http\Controllers\VocabularyIndex;
use App\Http\Controllers\VocabularyReview;
use App\Http\Controllers\VocabularySummary;

Route::get('/', function () {
    return redirect()->route('vocabulary.create');
});

Route::prefix('vocabulary')->name('vocabulary.')->group(function (): void {
    Route::get('/', VocabularyIndex::class)->name('index');
    Route::get('/create', VocabularyCreate::class)->name('create');
    Route::get('/{vocabulary}/edit', VocabularyEdit::class)->name('edit');
    Route::get('/review', VocabularyReview::class)->name('review');
    Route::get('/summary', VocabularySummary::class)->name('summary');
});
