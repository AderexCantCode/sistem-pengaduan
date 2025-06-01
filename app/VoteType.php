<?php

namespace App\Enums;

enum VoteType: string
{
    case Upvote = 'upvote';
    case Downvote = 'downvote';

    public function getLabel(): string
    {
        return match($this) {
            self::Upvote => 'Upvote',
            self::Downvote => 'Downvote',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
