<?php

namespace App\Http\Controllers;

use App\Enums\PartOfSpeech;
use App\Services\VocabularyService;
use Livewire\Component;

class VocabularyCreate extends Component
{
    public $word = '';
    public $partOfSpeech = '';
    public $pronunciation = '';
    public $meaning = '';

    protected $rules = [
        'word' => 'required|string|max:255',
        'partOfSpeech' => 'nullable|string',
        'pronunciation' => 'nullable|string|max:255',
        'meaning' => 'required|string',
    ];

    public function store()
    {
        $vocabularyService = app(VocabularyService::class);
        $this->validate();

        $data = [
            'word' => $this->word,
            'part_of_speech' => $this->partOfSpeech ?: null,
            'pronunciation' => $this->pronunciation ?: null,
            'meaning' => $this->meaning,
        ];

        $vocabularyService->create($data);

        // Reset form
        $this->reset(['word', 'partOfSpeech', 'pronunciation', 'meaning']);

        session()->flash('success', 'Từ mới đã được thêm!');
    }

    public function getPartsOfSpeechProperty()
    {
        return PartOfSpeech::options();
    }

    public function render()
    {
        return view('vocabulary-create', [
            'partsOfSpeech' => $this->partsOfSpeech,
        ]);
    }
}
