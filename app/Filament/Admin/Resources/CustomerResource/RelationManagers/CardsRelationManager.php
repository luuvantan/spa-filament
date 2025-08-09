<?php

namespace App\Filament\Admin\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardsRelationManager extends RelationManager
{
    protected static string $relationship = 'cards';
    protected static ?string $title = 'Theo dõi lộ trình';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->emptyStateHeading('Không có lộ trình nào')
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên thẻ dịch vụ'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sudung' => 'Đang hoạt động',
                        'hoanthanh' => 'Hoàn thành',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'sudung',
                        'danger' => 'hoanthanh',
                    ]),
                Tables\Columns\TextColumn::make('type')
                    ->label('Loại thẻ'),
                Tables\Columns\TextColumn::make('commission_per_session')
                    ->label('Lần sử dụng'),
                Tables\Columns\TextColumn::make('note')
                    ->label('Ghi chú'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
