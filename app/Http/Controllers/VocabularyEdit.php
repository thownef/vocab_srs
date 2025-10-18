<?php

namespace App\Http\Controllers;

use App\Enums\PartOfSpeech;
use App\Models\VocabularyWord;
use Livewire\Component;

class VocabularyEdit extends Component
{
    public VocabularyWord $word;
    public $wordText = '';
    public $partOfSpeech = '';
    public $pronunciation = '';
    public $meaning = '';

    protected $rules = [
        'wordText' => 'required|string|max:255',
        'partOfSpeech' => 'nullable|string',
        'pronunciation' => 'nullable|string|max:255',
        'meaning' => 'required|string',
    ];

    public function mount(VocabularyWord $vocabulary)
    {
        $this->word = $vocabulary;
        $this->wordText = $vocabulary->word;
        $this->partOfSpeech = $vocabulary->part_of_speech ?? '';
        $this->pronunciation = $vocabulary->pronunciation ?? '';
        $this->meaning = $vocabulary->meaning;
    }

    public function update()
    {
        $this->validate();

        $this->word->update([
            'word' => $this->wordText,
            'part_of_speech' => $this->partOfSpeech ?? null,
            'pronunciation' => $this->pronunciation ?? null,
            'meaning' => $this->meaning,
        ]);

        session()->flash('success', 'Cập nhật thành công!');
        return redirect()->route('vocabulary.index');
    }

    public function delete()
    {
        $this->word->delete();
        session()->flash('success', 'Đã xóa từ vựng!');
        return redirect()->route('vocabulary.index');
    }

    public function getPartsOfSpeechProperty()
    {
        return PartOfSpeech::options();
    }

    public function render()
    {
        return view('vocabulary-edit', [
            'partsOfSpeech' => $this->partsOfSpeech,
        ]);
    }
}
