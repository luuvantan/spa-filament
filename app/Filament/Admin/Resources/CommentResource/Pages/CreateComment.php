<?php

namespace App\Filament\Admin\Resources\CommentResource\Pages;

use App\Filament\Admin\Resources\CommentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

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
            ->title('Bình luận đã được tạo')
            ->success()
            ->body('Bình luận mới đã được tạo thành công.');
    }
}
