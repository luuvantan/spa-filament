<?php

namespace App\Filament\Admin\Resources\CustomerCardResource\Pages;

use App\Filament\Admin\Resources\CustomerCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerCards extends ListRecords
{
    protected static string $resource = CustomerCardResource::class;

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
