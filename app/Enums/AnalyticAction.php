<?php

namespace App\Enums;

enum AnalyticAction: string
{
    case View = 'view';
    case Share = 'share';

    public function getLabel(): string
    {
        return match ($this) {
            self::View => 'Lượt xem',
            self::Share => 'Chia sẻ',
        };
    }
}
