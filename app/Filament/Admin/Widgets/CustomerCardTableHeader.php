<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Customer;
use App\Models\CustomerCard;
use Filament\Widgets\Widget;

class CustomerCardTableHeader extends Widget
{
    protected static bool $isDiscovered = false;
    protected static string $view = 'filament.admin.widgets.customer-card-table-header';
    protected int | string | array $columnSpan = 'full';
    public string $search = '';
    public string $selectedStat = 'all';
    public $totalCustomers = 0;
    public $totalPriceTheLieuTrinh = 0;
    public $totalPriceTheTien = 0;
    public $expiringToday = 0;
    public $expiring7Day = 0;
    public $expiring3Month = 0;

    public function mount(): void
    {
        $this->totalCustomers = CustomerCard::count();
        $this->totalPriceTheLieuTrinh = CustomerCard::count();
        $this->totalPriceTheTien = CustomerCard::count();
        $lieuTrinhCards = CustomerCard::with('card')
            ->where('card_type', 'thelieutrinh')
            ->get();
        $this->totalPriceTheLieuTrinh = $lieuTrinhCards->sum('card.price');

        $tienCards = CustomerCard::with('card')
            ->where('card_type', 'thetien')
            ->get();
        $this->totalPriceTheTien = $tienCards->sum('card.price');

        $this->expiringToday = CustomerCard::whereMonth('end_date', now()->month)
            ->whereDay('end_date', now()->day)
            ->count();
        $this->expiring7Day = CustomerCard::whereBetween('end_date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();
        $this->expiring3Month = CustomerCard::count();
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
