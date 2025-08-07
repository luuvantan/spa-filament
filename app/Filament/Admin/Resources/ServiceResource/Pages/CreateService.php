<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getFormActions(): array
    {
        return [
            // Nút "Tạo"
            Actions\CreateAction::make()
                ->label('Lưu') // <-- Đổi nhãn nút nếu muốn
                ->extraAttributes([
                    'class' => 'my-custom-save-button', // <-- Thêm class CSS tùy chỉnh
                ]),

            // Bỏ comment dòng dưới nếu muốn giữ lại nút "Hủy"
            // Actions\CancelAction::make(),
        ];
    }
}
