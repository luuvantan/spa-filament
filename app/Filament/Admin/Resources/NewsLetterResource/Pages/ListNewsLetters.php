<?php

namespace App\Filament\Admin\Resources\NewsLetterResource\Pages;

use App\Filament\Admin\Resources\NewsLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsLetters extends ListRecords
{
    protected static string $resource = NewsLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
