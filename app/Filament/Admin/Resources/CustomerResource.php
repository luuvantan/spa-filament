<?php

namespace App\Filament\Admin\Resources;

use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Admin\Resources\CustomerResource\Pages;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
        // Đổi tên hiển thị trong menu và header
    protected static ?string $modelLabel = 'Khách hàng';
    protected static ?string $pluralModelLabel = 'Khách hàng';

    protected static ?string $navigationLabel = 'Khách hàng';
    protected static ?string $navigationGroup = 'Quản lý'; // tuỳ bạn nhóm

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make(2)->schema([

                    // ✅ Cột bên trái (Form)
                    Forms\Components\Section::make()
                        ->schema([

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên khách hàng')
                                    ->required()
                                    ->markAsRequired(),

                                Forms\Components\TextInput::make('occupation')
                                    ->label('Nghề nghiệp'),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\DatePicker::make('birthday')
                                    ->label('Ngày sinh'),

                                Forms\Components\TextInput::make('facebook')
                                    ->label('Facebook'),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('SĐT')
                                    ->required()
                                    ->markAsRequired(),

                                Forms\Components\Select::make('gender')
                                    ->label('Giới tính')
                                    ->options([
                                        'male' => 'Nam',
                                        'female' => 'Nữ',
                                        'other' => 'Khác',
                                    ])
                                    ->required()
                                    ->markAsRequired(),
                            ]),

                            Forms\Components\Select::make('rank')
                                ->label('Hạng')
                                ->options([
                                    'vip' => 'VIP',
                                    'normal' => 'Thường',
                                ])
                                ->required()
                                ->markAsRequired(),

                            Forms\Components\Section::make('Địa chỉ')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Select::make('city')
                                            ->label('Tp')
                                            ->required()
                                            ->markAsRequired(),
                                        Forms\Components\Select::make('ward')
                                            ->label('Phường/Xã')
                                            ->required()
                                            ->markAsRequired(),
                                        Forms\Components\Select::make('district')
                                            ->label('Quận')
                                            ->required()
                                            ->markAsRequired(),
                                    ]),
                                    Forms\Components\TextInput::make('address')
                                        ->label('Địa chỉ chi tiết')
                                        ->required()
                                        ->markAsRequired(),
                                ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\Select::make('source')
                                    ->label('Nguồn khách hàng')
                                    ->required()
                                    ->markAsRequired(),

                                Forms\Components\Select::make('referrer')
                                    ->label('Người giới thiệu'),

                                Forms\Components\Select::make('branch')
                                    ->label('Chi nhánh')
                                    ->required()
                                    ->markAsRequired(),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Textarea::make('note')
                                ->label('Ghi chú')
                                ->rows(5)
                                ->extraAttributes(['class' => 'h-full']),

                                Forms\Components\FileUpload::make('photo_path')
                                ->label('Ảnh khách hàng')
                                ->directory('customers')
                                ->image()
                                ->imageEditor()
                                ->extraAttributes(['class' => 'h-full']),
                            ])->extraAttributes(['class' => 'items-stretch']),
                            

                        ]),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Tên KH')->searchable(),
                Tables\Columns\TextColumn::make('birthday')->label('Ngày sinh'),
                Tables\Columns\TextColumn::make('phone')->label('SĐT'),
                Tables\Columns\TextColumn::make('gender')->label('Giới tính'),
                Tables\Columns\TextColumn::make('rank')->label('Hạng'),
                Tables\Columns\TextColumn::make('address')->label('Địa chỉ'),
                Tables\Columns\TextColumn::make('status')->label('Trạng thái'),
                Tables\Columns\TextColumn::make('note')->label('Ghi chú'),
            ])
            ->defaultSort('id', 'desc');
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
