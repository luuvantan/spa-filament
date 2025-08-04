<?php

namespace App\Filament\Admin\Resources\CardResource\Pages;

use App\Filament\Admin\Resources\CardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCards extends ListRecords
{
    protected static string $resource = CardResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }

    protected function getHeaderActions(): array
    {
        return [];
    }

}
