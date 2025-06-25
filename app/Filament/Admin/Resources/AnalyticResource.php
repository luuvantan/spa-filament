<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnalyticResource\Pages;
use App\Filament\Admin\Resources\AnalyticResource\RelationManagers;
use App\Models\Analytic;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnalyticResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;
    protected static ?string $model = Analytic::class;

    protected static ?string $modelLabel = 'Thống kê'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $activeNavigationIcon = 'heroicon-s-chart-bar-square';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 7;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAnalytics::route('/'),
            'create' => Pages\CreateAnalytic::route('/create'),
            'edit' => Pages\EditAnalytic::route('/{record}/edit'),
        ];
    }
}
