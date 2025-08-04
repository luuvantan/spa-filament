<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class CustomerTableHeader extends Widget
{
    protected static string $view = 'filament.admin.widgets.customer-table-header';

    protected int | string | array $columnSpan = 'full';
}
