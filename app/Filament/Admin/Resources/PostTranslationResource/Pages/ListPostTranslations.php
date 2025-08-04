<?php

namespace App\Filament\Admin\Resources\PostTranslationResource\Pages;

use App\Filament\Admin\Resources\PostTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostTranslations extends ListRecords
{
    protected static string $resource = PostTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
