<?php

namespace App\Filament\Admin\Resources\MediaResource\Pages;

use App\Filament\Admin\Resources\MediaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

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

    protected function handleRecordUpdate($record, array $data): \Illuminate\Database\Eloquent\Model
    {
        if (isset($data['url'])) {
            $data['url'] = Storage::url($data['url']);
        }

        return tap($record)->update($data);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Phương tiện đã được cập nhật')
            ->success()
            ->body('Phương tiện đã được cập nhật thành công.');
    }
}
