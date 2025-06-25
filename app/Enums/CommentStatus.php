<?php

namespace App\Enums;

enum CommentStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Spam = 'spam';

    public function getLabel(): string
    {
        return match ($this) {
            self::Approved => 'Đã phê duyệt',
            self::Pending => 'Đang chờ',
            self::Spam => 'Spam',
        };
    }
}
