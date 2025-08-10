<?php

namespace App\Filament\Admin\Resources\CustomerResource\Pages;

use App\Filament\Admin\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;
    public function getRelationManagers(): array
    {
        return [
            CustomerResource\RelationManagers\PaymentsRelationManager::class,
            CustomerResource\RelationManagers\CardsRelationManager::class,
            CustomerResource\RelationManagers\NotesRelationManager::class,
        ];
    }
}
