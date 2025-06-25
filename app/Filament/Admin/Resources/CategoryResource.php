<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Filament\Admin\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = Category::class;

    protected static ?string $modelLabel = 'Danh mục tin tức'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $activeNavigationIcon = 'heroicon-s-folder';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 2;

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
                Forms\Components\TextInput::make('name')
                    ->label('Tên danh mục')
                    ->placeholder('Nhập tên danh mục')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->label('Danh mục cha')
                    ->placeholder('Chọn danh mục cha')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('description')
                    ->label('Mô tả')
                    ->placeholder('Nhập mô tả'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Danh mục cha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Xem')
                    ->modalHeading('Thông tin danh mục')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('name')->label('Tên danh mục'),
                            TextEntry::make('slug')->label('Slug'),
                            TextEntry::make('parent.name')->label('Danh mục cha')->default('Không có danh mục cha'),
                            TextEntry::make('description')->label('Mô tả')->default('Không có mô tả'),
                        ]),
                    ])
                    ->slideOver(),
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
