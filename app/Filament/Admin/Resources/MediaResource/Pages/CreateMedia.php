<?php

namespace App\Filament\Admin\Resources\MediaResource\Pages;

use App\Filament\Admin\Resources\MediaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        if (isset($data['url'])) {
//            $data['url'] = Storage::url($data['url']); // Trả về /storage/file.pdf
//        }
//
//        return $data;
//    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Phương tiện đã được tạo')
            ->success()
            ->body('Phương tiện mới đã được tạo thành công.');
    }
}
