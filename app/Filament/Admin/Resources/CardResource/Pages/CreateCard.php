<?php

namespace App\Filament\Admin\Resources\CardResource\Pages;

use App\Filament\Admin\Resources\CardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;

class CreateCard extends CreateRecord
{
    protected static string $resource = CardResource::class;

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
