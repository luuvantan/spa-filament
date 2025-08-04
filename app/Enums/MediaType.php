<?php

namespace App\Enums;

enum MediaType: string
{
    case Image = 'image';
    case Video = 'video';
    case Document = 'document';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Image => 'Hình ảnh',
            self::Video => 'Video',
            self::Document => 'Tài liệu',
            self::Other => 'Khác',
        };
    }
}
