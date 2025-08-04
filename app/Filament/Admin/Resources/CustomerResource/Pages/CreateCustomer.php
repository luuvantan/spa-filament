<?php

namespace App\Filament\Admin\Resources\CustomerResource\Pages;

use App\Filament\Admin\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu')
                ->submit('create') // hoặc 'save' nếu là EditPage
                ->button()
                ->extraAttributes([
                    'class' => 'w-full justify-center', // Full chiều rộng & căn giữa
                ])
                ->color('primary'), // màu xanh
        ];
    }

    public static function hasBreadcrumbs(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return '';
    }

    // (Tùy chọn) Tắt subtitle nếu có
    public function getSubheading(): ?string
    {
        return null;
    }
    public function getFormAttributes(): array
    {
        return [
            'novalidate' => true,
        ];
    }
}
