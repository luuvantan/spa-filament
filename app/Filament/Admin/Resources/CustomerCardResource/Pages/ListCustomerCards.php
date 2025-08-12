<?php

namespace App\Filament\Admin\Resources\CustomerCardResource\Pages;

use App\Filament\Admin\Resources\CustomerCardResource;
use Filament\Actions;
use App\Filament\Admin\Widgets\CustomerCardTableHeader;
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
    protected function getHeaderWidgets(): array
    {
        return [
            CustomerCardTableHeader::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
