<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NewsLetterResource\Pages;
use App\Forms\Components\MyAdvancedFileUpload;
use App\Models\NewsLetter;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class NewsLetterResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = NewsLetter::class;

    protected static ?string $modelLabel = 'Bản tin tuần'; // customize ten cua model

    protected static bool $hasTitleCaseModelLabel = false; // khong viet hoa chu cai dau tien trong ten cua model

    protected static ?string $navigationIcon = 'heroicon-o-window';

    protected static ?string $activeNavigationIcon = 'heroicon-s-window';

    protected static ?string $navigationBadgeTooltip = 'Số bản tin tuần trong hệ thống';

    protected static ?string $navigationGroup = 'Quản lý tin tức';

    protected static ?int $navigationSort = 1;

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
                Components\Section::make('Thông tin bản tin')
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Tiêu đề')
                            ->markAsRequired()
                            ->rules(['required', 'max:255'])
                            ->validationMessages([
                                'required' => 'Tiêu đề không được để trống.',
                                'max' => 'Tiêu đề không được vượt quá :max ký tự.',
                            ]),
                        Components\Select::make('week_number')
                            ->label('Số tuần')
                            ->markAsRequired()
                            ->rules(['required'])
                            ->validationMessages([
                                'required' => 'Số tuần không được để trống.',
                            ])
                            ->placeholder('Chọn tuần')
                            ->options(
                                collect(range(1, 52))
                                    ->mapWithKeys(fn($week) => [$week => $week])
                            )
                            ->searchable()
                            ->optionsLimit(52)
                            ->preload()
                            ->default(date('W')),
                        Components\Select::make('year')
                            ->label('Năm')
                            ->markAsRequired()
                            ->rules(['required'])
                            ->validationMessages([
                                'required' => 'Năm không được để trống.',
                            ])
                            ->options(
                                collect(range(date('Y') - 25, date('Y') + 25))
                                    ->mapWithKeys(fn($year) => [$year => $year])
                            )
                            ->searchable()
                            ->optionsLimit(51)
                            ->preload()
                            ->default(date('Y')),
                    ])
                    ->columnSpan(1),
                Components\Section::make('File PDF')
                    ->schema([
                        MyAdvancedFileUpload::make('pdf_path')
                            ->markAsRequired()
                            ->directory('newsletters')
                            ->label("Upload Pdf")
                            ->pdfPreviewHeight(500)
                            ->pdfDisplayPage(1)
                            ->pdfToolbar(true)
                            ->pdfZoomLevel(100)
                            ->pdfFitType(PdfViewFit::FIT)
                            ->pdfNavPanes(true)
                            ->maxParallelUploads(1)
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->openable()
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadProgressIndicatorPosition('left')
                            ->acceptedFileTypes([
                                'application/pdf',
                            ])
                    ])
                    ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('week_year')
                    ->label('Tuần/Năm')
                    ->sortable(['week_number', 'year']),
                Tables\Columns\TextColumn::make('pdf_path')
                    ->label('File PDF')
                    ->formatStateUsing(fn($state) => $state ? '<a href="' . Storage::url($state) . '" target="_blank" class="text-primary-600">Xem PDF</a>' : 'Không có file')
                    ->html()
                    ->disableClick() 
                    ->extraAttributes(['class' => 'pointer-events-auto']),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('year')
                    ->label('Năm')
                    ->options(
                        collect(range(date('Y') - 25, date('Y') + 25))
                            ->mapWithKeys(fn($year) => [$year => $year])
                    ),
                Tables\Filters\SelectFilter::make('week_number')
                    ->label('Tuần')
                    ->options(
                        collect(range(1, 52))
                            ->mapWithKeys(fn($week) => [$week => "Tuần $week"])
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Xem')
                    ->modalHeading('Thông tin bản tin')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('title')
                                ->label('Tiêu đề'),
                            TextEntry::make('week_year')
                                ->label('Tuần/Năm'),
                            TextEntry::make('pdf_path')
                                ->label('File PDF')
                                ->formatStateUsing(fn($state) => $state ? '<a href="' . Storage::url($state) . '" target="_blank" class="text-primary-600">Xem PDF</a>' : 'Không có file')
                                ->html(),
                            TextEntry::make('created_at')
                                ->label('Ngày tạo')
                                ->dateTime('d/m/Y H:i:s'),
                        ]),
                    ])
                    ->slideOver(),
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->successNotification(
                        Notification::make()
                            ->title('Bản tin tuần đã xóa')
                            ->success()
                            ->body('Bản tin tuần đã được xóa thành công.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsLetters::route('/'),
            'create' => Pages\CreateNewsLetter::route('/create'),
            'edit' => Pages\EditNewsLetter::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string // customize so luong hien thi trong badge
    {
        return static::getModel()::count();
    }
}
