<?php

namespace App\Filament\Admin\Resources\CustomerResource\Pages;

use App\Filament\Admin\Resources\CustomerResource;
use Filament\Actions;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    public function getRelationManagers(): array
    {
        return [
            CustomerResource\RelationManagers\PaymentsRelationManager::class,
            CustomerResource\RelationManagers\CardsRelationManager::class
        ];
    }
}
