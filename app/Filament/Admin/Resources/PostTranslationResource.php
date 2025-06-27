<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostTranslationResource\Pages;
use App\Filament\Admin\Resources\PostTranslationResource\RelationManagers;
use App\Forms\Components\CKEditor;
use App\Models\PostTranslation;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class PostTranslationResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = PostTranslation::class;

    protected static ?string $modelLabel = 'Bản dịch'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $activeNavigationIcon = 'heroicon-s-clipboard-document-list';

    protected static ?string $navigationBadgeTooltip = 'Số bản dịch trong hệ thống';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 4;

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
                Forms\Components\Select::make('post_id')
                    ->label('Bài viết gốc')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload()
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Bài viết gốc không được để trống.',
                    ]),
                Forms\Components\TextInput::make('language')
                    ->label('Ngôn ngữ')
                    ->default('en')
                    ->helperText('Ví dụ: en, vi, fr, ...')
                    ->markAsRequired()
                    ->rules(['required', 'max:10'])
                    ->validationMessages([
                        'required' => 'Ngôn ngữ không được để trống.',
                        'max' => 'Ngôn ngữ không được vượt quá :max ký tự.',
                    ]),
                Forms\Components\TextInput::make('title')
                    ->label('Tiêu đề')
                    ->markAsRequired()
                    ->rules(['required', 'max:255'])
                    ->validationMessages([
                        'required' => 'Tiêu đề không được để trống.',
                        'max' => 'Tiêu đề không được vượt quá :max ký tự.',
                    ]),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Tóm tắt')
                    ->autosize()
                    ->rows(1)
                    ->maxLength(255)
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Tóm tắt không được để trống.',
                    ]),
                CKEditor::make('content')
                    ->label('Nội dung')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language')
                    ->label('Ngôn ngữ')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'vi' => 'success',
                        'en' => 'primary',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Bài viết gốc')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('language')
                    ->label('Ngôn ngữ')
                    ->options([
                        'vi' => 'Tiếng Việt',
                        'en' => 'Tiếng Anh',
                        'fr' => 'Tiếng Pháp',
                    ])
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('post')
                    ->label('Bài viết gốc')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Xem')
                    ->modalHeading('Thông tin bài viết')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('post.title')->label('Bài viết gốc'),
                            TextEntry::make('language')->label('Ngôn ngữ')
                                ->badge()
                                ->color(fn($state) => match ($state) {
                                    'vi' => 'success',
                                    'en' => 'primary',
                                    default => 'gray',
                                }),
                            TextEntry::make('title')->label('Tiêu đề'),
                            TextEntry::make('excerpt')->label('Tóm tắt'),
                            TextEntry::make('content')->label('Nội dung')->columnSpan('full')->html(),
                        ]),
                    ])
                    ->slideOver(),
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
            'index' => Pages\ListPostTranslations::route('/'),
            'create' => Pages\CreatePostTranslation::route('/create'),
            'edit' => Pages\EditPostTranslation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string // customize so luong hien thi trong badge
    {
        return static::getModel()::count();
    }
}
