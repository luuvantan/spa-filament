<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CardResource\Pages;
use App\Filament\Admin\Resources\CardResource\RelationManagers;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Get;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $modelLabel = 'Thẻ';

    protected static ?string $navigationGroup = 'Danh mục';
    protected static ?string $navigationLabel = 'Thẻ';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*
                // --- Trường khách hàng đã được tạm ẩn đi ---
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Khách hàng'),
                */

                TextInput::make('name')
                    ->required()
                    ->label('Tên thẻ')
                    ->columnSpanFull()
                ,

                Radio::make('type')
                    ->label('Loại thẻ')
                    ->options([
                        'Thẻ Liệu Trình' => 'Thẻ Liệu Trình',
                        'Thẻ Tiền' => 'Thẻ Tiền',
                    ])
                    ->default('Thẻ Liệu Trình')
                    ->inline(false)
                    ->extraAttributes(['class' => 'radio-options-inline custom-blue-radio'])
                    ->required()
                    ->live(),

                // Nhóm các trường chỉ hiện ra khi là 'Thẻ Liệu Trình'
                Grid::make(2)
                    ->schema([
                        // Cột 1: Chỉ chứa trường "Liệu trình"
                        TextInput::make('sessions')
                            ->label('Liệu trình')
                            ->numeric()
                            ->suffix('Buổi')
                            ->required(),

                        // Cột 2: Lại là một Grid con, chia đôi để chứa "Giờ" và "Phút"
                        Fieldset::make('Thời gian thực hiện/Buổi')
                            ->schema([
                                // Grid con để chia đôi cho Giờ và Phút
                                Grid::make(2)->schema([
                                    TextInput::make('hours')
                                        ->hiddenLabel() // Ẩn nhãn "Giờ"
                                        ->numeric()
                                        ->default(0)
                                        ->minValue(0)
                                        ->suffix('Giờ'),

                                    TextInput::make('minutes')
                                        ->hiddenLabel() // Ẩn nhãn "Phút"
                                        ->numeric()
                                        ->default(0)
                                        ->minValue(0)
                                        ->maxValue(59)
                                        ->suffix('Phút'),
                                ])
                            ]),
                    ])->visible(fn (Get $get): bool => $get('type') === 'Thẻ Liệu Trình'),

                // Grid cho 3 trường ngày trên cùng 1 hàng
                Grid::make(3)
                    ->schema([
                        DatePicker::make('issue_date')
                            ->required()
                            ->label('Ngày cấp'),
                        DatePicker::make('start_date')
                            ->required()
                            ->label('Ngày bắt đầu'),
                        DatePicker::make('end_date')
                            ->required()
                            ->label('Ngày kết thúc'),
                    ]),

                Textarea::make('notes')
                    ->label('Ghi chú')
                    ->rows(6)
                    ->columnSpanFull(),

                // Grid cho 2 trường giá và hoa hồng trên 1 hàng
                Grid::make(2)
                    ->schema([
                        TextInput::make('price')
                            ->label('Giá thẻ')
                            ->required()
                            ->numeric()
                            ->prefix('VNĐ'),
                        TextInput::make('commission_per_session')
                            ->label('Hoa hồng / Buổi')
                            ->numeric()
                            ->prefix('VNĐ')
                            ->visible(fn (Get $get): bool => $get('type') === 'Thẻ Liệu Trình'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên thẻ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Loại thẻ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sessions')
                    ->label('Số buổi')
                    ->numeric()
                    ->sortable(),

                // --- Định dạng lại ngày tháng ---
                Tables\Columns\TextColumn::make('issue_date')
                    ->label('Ngày tạo')
                    ->date('d/m/Y') // Định dạng dd/mm/yyyy
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Ngày bắt đầu')
                    ->date('d/m/Y') // Định dạng dd/mm/yyyy
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Ngày kết thúc')
                    ->date('d/m/Y') // Định dạng dd/mm/yyyy
                    ->sortable(),

                // --- Dùng BadgeColumn cho đẹp hơn ---
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
                    ])
                    ->searchable(),

                // --- Định dạng lại tiền tệ ---
                Tables\Columns\TextColumn::make('price')
                    ->label('Giá tiền thẻ')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_per_session')
                    ->label('Hoa hồng')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, ',', '.'))
                    ->sortable(),

                // --- Các cột ẩn mặc định ---
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tạo mới')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After),
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
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}
