<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PartOfSpeech;

class UpdateVocabularyRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'word' => 'required|string|max:255',
			'part_of_speech' => [
				'nullable',
				'string',
				Rule::in(array_keys(PartOfSpeech::options())),
			],
			'pronunciation' => 'nullable|string|max:100',
			'meaning' => 'required|string',
			'example' => 'nullable|string',
		];
	}
}
