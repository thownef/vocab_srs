<?php

namespace App\Enums;

enum PartOfSpeech: string
{
    case NOUN = 'noun';
    case VERB = 'verb';
    case ADJECTIVE = 'adjective';
    case ADVERB = 'adverb';
    case PRONOUN = 'pronoun';
    case PREPOSITION = 'preposition';
    case CONJUNCTION = 'conjunction';
    case INTERJECTION = 'interjection';
    case ARTICLE = 'article';
    case NUMERAL = 'numeral';

    public static function options(): array
    {
        return [
            self::NOUN->value => 'Danh từ',
            self::VERB->value => 'Động từ',
            self::ADJECTIVE->value => 'Tính từ',
            self::ADVERB->value => 'Trạng từ',
            self::PRONOUN->value => 'Đại từ',
            self::PREPOSITION->value => 'Giới từ',
            self::CONJUNCTION->value => 'Liên từ',
            self::INTERJECTION->value => 'Thán từ',
            self::ARTICLE->value => 'Mạo từ',
            self::NUMERAL->value => 'Số từ',
        ];
    }

    public static function label(?string $value): ?string
    {
        return $value ? (self::options()[$value] ?? $value) : null;
    }
}
