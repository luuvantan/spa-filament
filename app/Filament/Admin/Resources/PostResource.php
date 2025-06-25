<?php

namespace App\Filament\Admin\Resources;

use App\Enums\PostStatus;
use App\Filament\Admin\Resources\PostResource\Pages;
use App\Filament\Admin\Resources\PostResource\RelationManagers;
use App\Forms\Components\CKEditor;
use App\Models\Post;
use App\Models\Tag;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = Post::class;

    protected static ?string $modelLabel = 'Bài viết'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $activeNavigationIcon = 'heroicon-s-newspaper';

    protected static ?string $navigationBadgeTooltip = 'Số bài viết trong hệ thống';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 1;

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
                Forms\Components\TextInput::make('title')
                    ->label('Tiêu đề')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label('Danh mục')
                    ->placeholder('Chọn danh mục')
                    ->relationship('category', 'name')
                    ->required(),
                CKEditor::make('content')
                    ->label('Nội dung')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('excerpt')
                    ->label('Tóm tắt')
                    ->maxLength(500),
                Forms\Components\Select::make('user_id')
                    ->label('Người đăng')
                    ->placeholder('Chọn người đăng')
                    ->relationship('author', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Ngày đăng')
                    ->displayFormat('d/m/Y H:i:s')
                    ->default(now()),
                Forms\Components\TextInput::make('image_url')
                    ->prefix('https://')
                    ->label('Ảnh bài đăng')
                    ->url(),
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options(
                        collect(PostStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                    )
                    ->default(PostStatus::Draft->value)
                    ->required(),
                Forms\Components\TextInput::make('language')
                    ->label('Ngôn ngữ')
                    ->default('vi'),
                Forms\Components\TextInput::make('views')
                    ->label('Lượt xem')
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('tags')
                    ->label('Thẻ')
                    ->placeholder('Chọn thẻ')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Tag::class, 'slug'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Người đăng')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->getLabel())
                    ->color(fn($state) => $state->getColor()),
                Tables\Columns\TextColumn::make('published_at')->dateTime('d/m/Y H:i:s')
                    ->label('Ngày đăng')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Lượt xem')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Thẻ')
                    ->badge()
                    ->color('primary')
                    ->listWithLineBreaks()
                    ->limitList(3),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->multiple()
                    ->options(
                        collect(PostStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                    ),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->preload(),
                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Người đăng')
                    ->relationship('author', 'name')
                    ->multiple()
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
                            TextEntry::make('title')->label('Tiêu đề'),
                            TextEntry::make('content')->label('Nội dung')->columnSpan('full'),
                            TextEntry::make('excerpt')->label('Tóm tắt'),
                            TextEntry::make('category.name')->label('Danh mục'),
                            TextEntry::make('author.name')->label('Người đăng'),
                            TextEntry::make('excerpt')->label('Tóm tắt'),
                            TextEntry::make('status')
                                ->formatStateUsing(fn($state) => $state->getLabel())
                                ->label('Trạng thái'),
                            TextEntry::make('published_at')->label('Ngày đăng'),
                            TextEntry::make('views')->label('Lượt xem'),
                            TextEntry::make('language')->label('Ngôn ngữ'),
                            TextEntry::make('image_url')
                                ->label('Ảnh bài đăng')
                                ->formatStateUsing(fn($state) => $state ? "<a href='$state' target='_blank' style='color: blue; text-decoration: underline;'>Xem ảnh</a>" : 'Không có ảnh')
                                ->html(),
                            TextEntry::make('tags.name')
                                ->label('Thẻ')
                                ->listWithLineBreaks(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'excerpt', 'author.name'];
    }

    public static function getGlobalSearchResultDetails(Model|\Illuminate\Database\Eloquent\Model $record): array
    {
        // Customize hien thi chi tiet ket qua tim kiem toan cuc
        return [
            'Title' => $record->title,
            'Author' => $record->author->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // eager-load relationship to optimize performance
        return parent::getGlobalSearchEloquentQuery()->with(['author']);
    }

    public static function getGlobalSearchResultUrl(Model|\Illuminate\Database\Eloquent\Model $record): string
    {
        // link chuyen huong sau khi bam vao ban ghi
        return self::getUrl('edit', ['record' => $record]);
    }

    public static function getGlobalSearchResultActions(Model|\Illuminate\Database\Eloquent\Model $record): array
    {
        // cac hanh dong hien thi trong ket qua tim kiem toan cuc
        return [
            Action::make('edit')
                ->label('Sửa')
                ->url(static::getUrl('edit', ['record' => $record]), true),
        ];
    }

    public static function getNavigationBadge(): ?string // customize so luong hien thi trong badge
    {
        return static::getModel()::count();
    }
}
