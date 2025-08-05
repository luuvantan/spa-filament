<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Customer;
use Filament\Widgets\Widget;

class CustomerTableHeader extends Widget
{
    protected static string $view = 'filament.admin.widgets.customer-table-header';

    protected int | string | array $columnSpan = 'full';

    public string $search = '';

    // Gọi mỗi khi giá trị của $search thay đổi (wire:model.live)
    public function updatedSearch(string $value): void
    {
        // Gửi sự kiện 'searchChanged' đến ListCustomers
        $this->dispatch('searchChanged', search: $value);
    }
}
