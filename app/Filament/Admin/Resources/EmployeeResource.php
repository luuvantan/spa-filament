<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EmployeeResource\Pages;
use App\Filament\Admin\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Tên nhân viên')
                ->required()
                ->maxLength(255),
    
            Forms\Components\TextInput::make('phone')
                ->label('Số điện thoại')
                ->tel()
                ->required()
                ->maxLength(20),
    
            Forms\Components\TextInput::make('cccd')
                ->label('CCCD')
                ->required()
                ->maxLength(20),
    
            Forms\Components\DatePicker::make('birthday')
                ->label('Ngày sinh')
                ->required(),
    
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),
    
            Forms\Components\Textarea::make('address')
                ->label('Địa chỉ')
                ->rows(3)
                ->maxLength(500),
    
            Forms\Components\Select::make('branch_id')
                ->label('Chi nhánh làm việc')
                ->relationship('branch', 'name')
                ->searchable()
                ->preload()
                ->required(),
    
            Forms\Components\Select::make('position_id')
                ->label('Chức vụ')
                ->relationship('position', 'name')
                ->searchable()
                ->preload()
                ->required(),
    
            Forms\Components\Select::make('created_by')
                ->label('Người tạo')
                ->relationship('creator', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->default(auth()->id())
                ->disabled(fn ($record) => $record !== null), // Chỉ chọn lúc tạo
    
            Forms\Components\DateTimePicker::make('created_at')
                ->label('Ngày tạo')
                ->default(now())
                ->disabled(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

}
