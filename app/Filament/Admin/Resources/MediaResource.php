<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MediaResource\Pages;
use App\Forms\Components\MyAdvancedFileUpload;
use App\Models\Media;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class MediaResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = Media::class;

    protected static ?string $modelLabel = 'Phương tiện'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $activeNavigationIcon = 'heroicon-s-camera';

    protected static ?string $navigationBadgeTooltip = 'Số phương tiện trong hệ thống';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 6;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MyAdvancedFileUpload::make('url')
                    ->required()
                    ->label("Upload Pdf")
                    ->pdfPreviewHeight(630) // Customize preview height
                    ->pdfDisplayPage(1) // Set default page
                    ->pdfToolbar(true) // Enable toolbar
                    ->pdfZoomLevel(100) // Set zoom level
                    ->pdfFitType(PdfViewFit::FIT) // Set fit type
                    ->pdfNavPanes(true)
                    ->maxParallelUploads(1)
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
//                    ->panelAspectRatio('21:9')
                    ->openable()
//                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
//                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
//                    ->panelLayout('compact')         // 👈 Nếu cần hiển thị theo dạng lưới
//                    ->itemPanelAspectRatio(1)
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label('Link')
                    ->url(fn($record) => Storage::disk('public')->url($record->url))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Loại')
                    ->formatStateUsing(fn($state) => $state->getLabel()),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Bài viết')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->successNotification(
                        Notification::make()
                            ->title('Bài viết đã xóa')
                            ->success()
                            ->body('Bài viết đã được xóa thành công.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string // customize so luong hien thi trong badge
    {
        return static::getModel()::count();
    }
}
