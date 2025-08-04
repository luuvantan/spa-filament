<?php

namespace App\Filament\Admin\Resources\NewsLetterResource\Pages;

use App\Filament\Admin\Resources\NewsLetterResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsLetter extends CreateRecord
{
    protected static string $resource = NewsLetterResource::class;

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
            ->title('Bản tin tuần đã được tạo')
            ->success()
            ->body('Bản tin tuần mới đã được tạo thành công.');
    }
}
