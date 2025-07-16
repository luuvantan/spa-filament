<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerResource\Pages;
use App\Filament\Admin\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, DatePicker, Select};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Filament\Forms\Components\Grid;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Khách hàng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Khách hàng';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('name')->label('Họ tên')->required(),
                TextInput::make('phone')->label('Số điện thoại')->required(),
                TextInput::make('email')->label('Email')->email(),
                DatePicker::make('birthday')->label('Ngày sinh'),
                Select::make('gender')->label('Giới tính')->options([
                    'male' => 'Nam',
                    'female' => 'Nữ',
                    'other' => 'Khác',
                ]),
                Select::make('customer_type')->label('Loại khách hàng')->options([
                    'regular' => 'Thường',
                    'vip' => 'VIP',
                    'new' => 'Mới',
                ]),
                TextInput::make('address')->label('Địa chỉ'),
                TextInput::make('hometown')->label('Quê quán'),
                Textarea::make('note')->label('Ghi chú')->rows(3)->columnSpan(2),
                // TextInput::make('visit_count')->label('Số lần đến')->numeric()->default(0)->disabled(),
            ])
        ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('visit_count')->label('Lượt đến')->sortable(),
                TextColumn::make('created_at')->date('d/m/Y')->label('Ngày đăng ký'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
