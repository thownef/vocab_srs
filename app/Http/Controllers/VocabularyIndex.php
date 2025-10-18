<?php

namespace App\Http\Controllers;

use App\Enums\PartOfSpeech;
use App\Models\VocabularyWord;
use Livewire\Component;
use Livewire\WithPagination;

class VocabularyIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $partOfSpeech = '';
    public $perPage = 15;

    protected $queryString = [
        'search' => ['except' => ''],
        'partOfSpeech' => ['except' => '', 'as' => 'part_of_speech'],
    ];

    public function mount()
    {
        $this->search = request('search', '');
        $this->partOfSpeech = request('part_of_speech', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPartOfSpeech()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->partOfSpeech = '';
        $this->resetPage();
    }

    public function deleteWord($wordId)
    {
        $word = VocabularyWord::find($wordId);
        if ($word) {
            $word->delete();
            session()->flash('success', 'Đã xóa từ vựng!');
        }
    }

    public function getWordsProperty()
    {
        return VocabularyWord::query()
            ->search($this->search)
            ->partOfSpeech($this->partOfSpeech)
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function getPartsOfSpeechProperty()
    {
        return PartOfSpeech::options();
    }

    public function render()
    {
        return view('vocabulary-index', [
            'words' => $this->words,
            'partsOfSpeech' => $this->partsOfSpeech,
        ]);
    }
}
