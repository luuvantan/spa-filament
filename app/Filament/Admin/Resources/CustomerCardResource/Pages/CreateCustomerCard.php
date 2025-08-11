<?php

namespace App\Filament\Admin\Resources\CustomerCardResource\Pages;

use App\Filament\Admin\Resources\CustomerCardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerCard extends CreateRecord
{
    protected static string $resource = CustomerCardResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Lưu') // Tùy chỉnh nhãn
                ->extraAttributes([
                    'class' => 'my-custom-save-button', // Thêm class CSS tùy chỉnh
                ]),

            // Giữ nút "Hủy" nếu muốn
//            $this->getCancelFormAction(),
        ];
    }
}
