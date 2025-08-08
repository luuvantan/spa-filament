<?php

namespace App\Filament\Exports;

use App\Models\Customer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerExporter extends Exporter
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Tên khách hàng'),
            ExportColumn::make('birthday')->label('Ngày sinh'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Quá trình xuất dữ liệu khách hàng đã hoàn tất và ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' đã được xuất ra.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
