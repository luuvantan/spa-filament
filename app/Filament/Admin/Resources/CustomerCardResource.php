<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerCardResource\Pages;
use App\Filament\Admin\Resources\CustomerCardResource\RelationManagers;
use App\Models\CustomerCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class CustomerCardResource extends Resource
{
    protected static ?string $model = CustomerCard::class;

    protected static ?string $modelLabel = 'Danh sách người dùng thẻ';

    protected static ?string $navigationGroup = 'Danh mục';

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationIcon = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('card_id')
                    ->relationship('card', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Tên thẻ')
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    Select::make('customer_id')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('Khách hàng'),
                        Select::make('branch_id')
//                            ->relationship('branch', 'name')
                            ->options([
                                '1' => 'Hà Nội',
                                '2' => 'Hải Phong',
                            ])
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Chi nhánh'),
                ]),

                Grid::make(3)->schema([
                    DatePicker::make('issue_date')
                        ->required()
                        ->label('Ngày cấp')
                        ->default(now()),
                    DatePicker::make('start_date')
                        ->required()
                        ->label('Ngày bắt đầu')
                        ->default(now()),
                    DatePicker::make('end_date')
                        ->required()
                        ->label('Ngày kết thúc'),
                ]),

                Textarea::make('notes')
                    ->label('Ghi chú')
                    ->placeholder('Chọn thông tin')
                    ->rows(4)
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    Select::make('card_type')
                        ->options([
                            'thelieutrinh' => 'Thẻ liệu trình',
                            'thetien' => 'Thẻ tiền',
                        ])
                        ->required()
                        ->label('Loại thẻ'),
                    TextInput::make('quantity')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->label('Số lượng thẻ'),
                ]),
                Grid::make(1)->schema([
                    Tabs::make('Tabs')
                        ->extraAttributes(['class' => 'custom-tabs-customer-card'])
                        ->tabs([
                            Tabs\Tab::make('Dịch vụ')
                                ->schema([
                                    Repeater::make('services')
                                        ->relationship()
                                        ->hiddenLabel()
                                        ->schema([
                                            TextInput::make('name') // <-- Đổi thành 'name' để khớp với model Service
                                            ->placeholder('Dịch vụ') // <-- Thêm placeholder
//                                            ->required()
                                                ->hiddenLabel(), // <-- Ẩn label

                                            TextInput::make('sessions')
                                                ->placeholder('Số buổi') // <-- Thêm placeholder
                                                ->numeric()
//                                                ->required()
                                                ->hiddenLabel(), // <-- Ẩn label

                                            Select::make('status')
                                                ->placeholder('Trạng thái') // <-- Thêm placeholder
                                                ->options([
                                                    'Đang thực hiện' => 'Đang thực hiện',
                                                    'Chưa thực hiện' => 'Chưa thực hiện',
                                                ])
//                                                ->required()
                                                ->hiddenLabel(), // <-- Ẩn label
                                        ])
                                        ->columns(3)
                                        ->addActionLabel('Thêm dịch vụ'),
                                ]),
                            Tabs\Tab::make('Ghi chú')
//                                ->schema([
//                                    Textarea::make('service_notes')->label('Nội dung ghi chú'),
//                                ]),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')->label('Khách hàng')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('card.name')->label('Tên thẻ')->searchable(),
//                Tables\Columns\TextColumn::make('branch.name')->label('Chi nhánh')->searchable(),
                Tables\Columns\TextColumn::make('end_date')->label('Ngày hết hạn')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tạo mới')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After),
                Tables\Actions\Action::make('view_cards') // Tên định danh, cần là duy nhất
                ->label('DS các loại thẻ')
                    ->url(CardResource::getUrl('index')) // Lấy URL của trang index CardResource
//                    ->openUrlInNewTab() // Mở tab mới
                    ->color('gray') // Đổi màu nút cho khác biệt (ví dụ: success, warning, danger...)
                    ->icon('heroicon-o-list-bullet')
                    ->extraAttributes([
                        'class' => 'my-custom-link-button br-12', // <-- Thêm class của bạn ở đây
                    ]),
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
            'index' => Pages\ListCustomerCards::route('/'),
            'create' => Pages\CreateCustomerCard::route('/create'),
            'edit' => Pages\EditCustomerCard::route('/{record}/edit'),
        ];
    }
}
