<?php

namespace App\Filament\Admin\Resources\NewsLetterResource\Pages;

use App\Filament\Admin\Resources\NewsLetterResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditNewsLetter extends EditRecord
{
    protected static string $resource = NewsLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getFormActionsAlignment(): string
    {
        return 'right';
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Bản tin tuần đã được cập nhật')
            ->success()
            ->body('Bản tin tuần đã được cập nhật thành công.');
    }
}
