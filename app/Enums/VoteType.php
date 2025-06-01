<?php

namespace App\Enums;

enum VoteType: string
{
    case Upvote = 'upvote';
    case Downvote = 'downvote';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
