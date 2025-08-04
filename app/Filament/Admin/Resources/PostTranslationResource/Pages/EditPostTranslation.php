<?php

namespace App\Filament\Admin\Resources\PostTranslationResource\Pages;

use App\Filament\Admin\Resources\PostTranslationResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPostTranslation extends EditRecord
{
    protected static string $resource = PostTranslationResource::class;

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
            ->title('Bản dịch đã được cập nhật')
            ->success()
            ->body('Bản dịch đã được cập nhật thành công.');
    }
}
