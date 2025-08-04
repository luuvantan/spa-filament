<?php

namespace App\Filament\Admin\Resources;

use App\Enums\CommentStatus;
use App\Filament\Admin\Resources\CommentResource\Pages;
use App\Filament\Admin\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
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

class CommentResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = Comment::class;

    protected static ?string $modelLabel = 'Bình luận'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $activeNavigationIcon = 'heroicon-s-chat-bubble-left-right';

    protected static ?string $navigationBadgeTooltip = 'Số bình luận trong hệ thống';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 5;

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
                    ->label('Bài viết')
                    ->placeholder('Chọn bài viết')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload()
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Bài viết không được để trống.',
                    ]),
                Forms\Components\Select::make('user_id')
                    ->label('Người đăng')
                    ->placeholder('Chọn người đăng')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Người đăng không được để trống.',
                    ]),
                Forms\Components\Select::make('parent_id')
                    ->label('Bình luận cha')
                    ->placeholder('Chọn bình luận cha (nếu có)')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'content',
                        modifyQueryUsing: fn($query, $get) => $query
                            ->whereNull('parent_id')
                            ->where('id', '!=', $get('id') ?? 0)
                    )
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Textarea::make('content')
                    ->label('Nội dung')
                    ->autosize()
                    ->rows(1)
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Nội dung không được để trống.',
                    ]),
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options(
                        collect(CommentStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                    )
                    ->default(CommentStatus::Pending->value)
                    ->searchable()
                    ->preload()
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Trạng thái không được để trống.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->label('Nội dung')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Bài viết')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Người đăng')
                    ->searchable()
                    ->sortable()
                    ->default('Ẩn danh'),
                Tables\Columns\TextColumn::make('parent.content')
                    ->label('Bình luận cha')
                    ->limit(30)
                    ->default('Không có')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->getLabel())
                    ->color(fn($state) => $state->getColor()),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->multiple()
                    ->options(
                        collect(CommentStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                    ),
                Tables\Filters\SelectFilter::make('post_id')
                    ->label('Bài viết')
                    ->relationship('post', 'title')
                    ->multiple()
                    ->preload(),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Người đăng')
                    ->relationship('user', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Xem')
                    ->modalHeading('Thông tin bình luận')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('content')
                                ->label('Nội dung')
                                ->columnSpan('full'),
                            TextEntry::make('post.title')
                                ->label('Bài viết'),
                            TextEntry::make('user.name')
                                ->label('Người đăng')
                                ->default('Ẩn danh'),
                            TextEntry::make('parent.content')
                                ->label('Bình luận cha')
                                ->default('Không có'),
                            TextEntry::make('status')
                                ->label('Trạng thái')
                                ->badge()
                                ->formatStateUsing(fn($state) => $state->getLabel())
                                ->color(fn($state) => $state->getColor()),
                            TextEntry::make('created_at')
                                ->label('Ngày đăng')
                                ->dateTime('d/m/Y H:i:s'),
                        ]),
                    ])
                    ->slideOver(),
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->successNotification(
                        Notification::make()
                            ->title('Bình luận đã xóa')
                            ->success()
                            ->body('Bình luận đã được xóa thành công.')
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string // customize so luong hien thi trong badge
    {
        return static::getModel()::count();
    }
}
