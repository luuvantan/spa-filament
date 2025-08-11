<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Customer;
use Filament\Widgets\Widget;

class CustomerTableHeader extends Widget
{
    protected static bool $isDiscovered = false;
    protected static string $view = 'filament.admin.widgets.customer-table-header';
    protected int | string | array $columnSpan = 'full';
    public string $search = '';
    public string $selectedStat = 'all';
    public $totalCustomers = 0;
    public $newCustomers = 0;
    public $todayBirthdays = 0;
    public $weekBirthdays = 0;
    public $monthBirthdays = 0;

    public function mount(): void
    {
        $this->totalCustomers = Customer::count();
        $this->newCustomers = Customer::whereDate('created_at', today())->count();
        $this->todayBirthdays = Customer::whereMonth('birthday', now()->month)
            ->whereDay('birthday', now()->day)
            ->count();
        $this->weekBirthdays = Customer::whereBetween('birthday', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();
        $this->monthBirthdays = Customer::whereMonth('birthday', now()->month)->count();
    }

    // Gọi mỗi khi giá trị của $search thay đổi (wire:model.live)
    public function updatedSearch(string $value): void
    {
        // Gửi sự kiện 'searchChanged' đến ListCustomers
        $this->dispatch('searchChanged', search: $value);
    }
    public function loadCustomer(string $type): void
    {
        $this->selectedStat = $type;
        $this->dispatch('selectedStatChanged', filter: $type);
    }
}
