<?php

namespace App\Filament\Admin\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $title = 'Lịch sử giao dịch';
    public string $search = '';
    public int $totalAmount = 0;
    public int $totalPaid = 0;
    public int $totalDue = 0;
    public int $paymentTimes = 0;
    public int $totalInvoice = 0;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_code')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->emptyStateHeading('Không tìm thấy giao dịch nào')
            ->header(function () {
                return view('filament.admin.widgets.payment-table-header', [
                    'totalAmount' =>  number_format($this->totalAmount, 0, '.', ','),
                    'totalPaid' => number_format($this->totalPaid , 0, '.', ','),
                    'totalDue' => number_format($this->totalDue , 0, '.', ','),
                    'paymentTimes' => $this->paymentTimes,
                    'totalInvoice' => $this->totalInvoice,
                    'search' => $this->search,
                    'filters' => $this->getTableFiltersForm(),
                ]);
            })
            ->recordTitleAttribute('invoice_code')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_code')
                    ->label('Mã hóa đơn')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'conno'=> 'Còn nợ',
                        'hoanthanh' => 'Hoàn thành',
                        default => $state
                    })
                    ->colors([
                        'success' => 'hoanthanh',
                        'danger' => 'conno',
                    ]),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Tổng tiền')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ',')),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label('Đã trả')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ',')),
                Tables\Columns\TextColumn::make('amount_due')
                    ->label('Còn nợ')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ',')),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Hình thức'),
                Tables\Columns\TextColumn::make('note')
                    ->label('Ghi chú')
            ])
            ->searchable(false)
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'hoanthanh' => 'Hoàn thành',
                        'conno'     => 'Còn nợ',
                    ])

            ])

            ->headerActions([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
    public function updatedSearch($search): void
    {
        $this->tableSearch = $search;
        $this->resetPage();
    }
    public function calulateStats() : void
    {
        $query = $this->ownerRecord->payments();
        $this->totalAmount = $query->sum('total_amount');
        $this->totalPaid = $query->sum('amount_paid');
        $this->totalDue = $query->sum('amount_due');
        $this->paymentTimes = $query->where('customer_id', $this->ownerRecord->id)->distinct('invoice_code')->count();
    }
    public function mount() : void
    {
        $this->calulateStats();
    }
}
