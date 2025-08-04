<?php

namespace App\Filament\Admin\Resources\CategoryResource\Pages;

use App\Filament\Admin\Resources\CategoryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getFormActionsAlignment(): string
    {
        return 'right';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Danh mục tin tức đã được tạo')
            ->success()
            ->body('Danh mục tin tức mới đã được tạo thành công.');
    }
}
