<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Filament\Admin\Resources\PostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

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
            ->title('Bài viết đã được tạo')
            ->success()
            ->body('Bài viết mới đã được tạo thành công.');
    }
}
