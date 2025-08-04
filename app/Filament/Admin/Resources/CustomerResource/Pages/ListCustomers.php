<?php

namespace App\Filament\Admin\Resources\CustomerResource\Pages;

use App\Filament\Admin\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Customer;
use Filament\Forms\Components\Tabs;



class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    public function paginationView(): string
    {
        return 'vendor.livewire.components.pagination';
    }
    
    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
    // protected static string $view = 'filament.customers.list';

    // public function getViewData(): array
    // {
    //     return [
    //         'total' => Customer::count(),
    //         'today' => Customer::whereDate('created_at', today())->count(),
    //         'birthday_today' => Customer::whereMonth('birthday', now()->month)
    //             ->whereDay('birthday', now()->day)
    //             ->count(),
    //         'birthday_week' => Customer::whereBetween('birthday', [now()->startOfWeek(), now()->endOfWeek()])->count(),
    //         'birthday_month' => Customer::whereMonth('birthday', now()->month)->count(),
    //     ];
    // }

    
}
