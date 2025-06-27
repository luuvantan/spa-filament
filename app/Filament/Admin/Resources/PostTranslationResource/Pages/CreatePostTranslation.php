<?php

namespace App\Filament\Admin\Resources\PostTranslationResource\Pages;

use App\Filament\Admin\Resources\PostTranslationResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePostTranslation extends CreateRecord
{
    protected static string $resource = PostTranslationResource::class;

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
            ->title('Bản dịch đã được tạo')
            ->success()
            ->body('Bản dịch mới đã được tạo thành công.');
    }
}
