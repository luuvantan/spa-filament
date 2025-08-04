<?php

namespace App\Filament\Admin\Resources;

use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Filters\Tabs\Tab;
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

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('')
                            ->content('Thêm mới Khách hàng')
                            ->extraAttributes([
                                'class' => 'text-xl font-bold text-gray-800',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Tên khách hàng')
                                ->markAsRequired()
                                ->rules(['required', 'string', 'max:255']),

                            Forms\Components\TextInput::make('occupation')
                                ->label('Nghề nghiệp')
                                ->rules(['nullable', 'string', 'max:255']),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\DatePicker::make('birthday')
                                ->label('Ngày sinh')
                                ->rules(['nullable', 'date']),

                            Forms\Components\TextInput::make('facebook')
                                ->label('Facebook')
                                ->rules(['nullable', 'string', 'max:255']),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('phone')
                                ->label('SĐT')
                                ->markAsRequired()
                                ->rules(['required', 'string', 'max:20']),

                            Forms\Components\Select::make('gender')
                                ->label('Giới tính')
                                ->options([
                                    'male' => 'Nam',
                                    'female' => 'Nữ',
                                    'other' => 'Khác',
                                ])
                                ->markAsRequired()
                                ->rules(['required', 'in:male,female,other']),
                        ]),

                        Forms\Components\Select::make('rank')
                            ->label('Hạng')
                            ->options([
                                'vip' => 'VIP',
                                'normal' => 'Thường',
                            ])
                            ->markAsRequired()
                            ->rules(['required', 'in:vip,normal']),

                        Forms\Components\Section::make('Địa chỉ')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\Select::make('city')
                                        ->label('Tp')
                                        ->markAsRequired()
                                        ->rules(['required']),

                                    Forms\Components\Select::make('ward')
                                        ->label('Phường/Xã')
                                        ->markAsRequired()
                                        ->rules(['required']),

                                    Forms\Components\Select::make('district')
                                        ->label('Quận')
                                        ->markAsRequired()
                                        ->rules(['required']),
                                ]),
                                Forms\Components\TextInput::make('address')
                                    ->label('Địa chỉ chi tiết')
                                    ->markAsRequired()
                                    ->rules(['required', 'string', 'max:255']),
                            ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('source')
                                ->label('Nguồn khách hàng')
                                ->markAsRequired()
                                ->rules(['required']),

                            Forms\Components\Select::make('referrer')
                                ->label('Người giới thiệu')
                                ->rules(['nullable']),

                            Forms\Components\Select::make('branch')
                                ->label('Chi nhánh')
                                ->markAsRequired()
                                ->rules(['required']),
                        ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Textarea::make('note')
                                    ->label('Ghi chú')
                                    ->rows(10)
                                    ->rules(['nullable', 'string'])
                                    ->extraAttributes(['class' => 'h-full min-h-[220px]']),

                                Forms\Components\FileUpload::make('photo_path')
                                    ->label('Ảnh khách hàng')
                                    ->directory('customers')
                                    ->image()
                                    ->imageEditor()
                                    ->rules(['nullable', 'image', 'max:2048'])
                                    ->extraAttributes([
                                        'class' => 'h-full min-h-[220px] flex items-center justify-center border border-gray-300 rounded-md',
                                    ]),
                            ])
                            ->extraAttributes(['class' => 'items-stretch gap-4']),
                    ]),
            ]),
        ]);


    }

    public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            // ID hiển thị màu, đứng riêng
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->formatStateUsing(fn ($state) => 'ID ' . $state)
                ->color('primary')
                ->sortable(),

            // Tên khách hàng
            Tables\Columns\TextColumn::make('name')
                ->label('Tên KH')
                ->searchable()
                ->description(fn (Customer $record) => $record->name),

            Tables\Columns\TextColumn::make('birthday')
                ->label('Ngày sinh')
                ->date('d/m/Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('phone')
                ->label('SĐT'),

            Tables\Columns\TextColumn::make('gender')
                ->label('Giới tính')
                ->formatStateUsing(fn ($state) => match ($state) {
                    'male' => 'Nam',
                    'female' => 'Nữ',
                    'other' => 'Khác',
                    default => '-',
                }),

            Tables\Columns\TextColumn::make('rank')
                ->label('Hạng'),

            Tables\Columns\TextColumn::make('address')
                ->label('Địa chỉ'),

            Tables\Columns\TextColumn::make('status')
                ->label('Trạng thái')
                ->badge()
                ->formatStateUsing(fn ($state) => $state === 'active' ? 'Đang hoạt động' : 'Tạm ngưng')
                ->color(fn ($state) => $state === 'active' ? 'success' : 'danger'),

            Tables\Columns\TextColumn::make('note')
                ->label('Ghi chú')
                ->wrap()
                ->limit(40)
                ->tooltip(fn (Customer $record) => $record->note), // hover hiện đủ nội dung
        ])
        ->filters([
            // nếu cần thêm bộ lọc như trạng thái, giới tính...
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        
        ->striped()
        ->paginated([10, 25, 50]);
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
