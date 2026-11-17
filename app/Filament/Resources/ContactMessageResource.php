<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Pesan Masuk';

    protected static ?string $navigationLabel = 'Pesan Masuk';

    protected static ?string $modelLabel = 'Pesan Masuk';

    protected static ?string $pluralModelLabel = 'Pesan Masuk';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $unread = ContactMessage::where('is_read', false)->count();
        return $unread > 0 ? (string) $unread : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pesan Pengunjung')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Pengirim')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->disabled(),

                        Forms\Components\Toggle::make('is_read')
                            ->label('Status: Sudah Dibaca / Ditanggapi')
                            ->default(false),

                        Forms\Components\Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(8)
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight('bold')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large)
                            ->icon('heroicon-m-user')
                            ->searchable()
                            ->grow(false),

                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->color('gray')
                            ->copyable()
                            ->searchable()
                            ->grow(false),

                        Tables\Columns\IconColumn::make('is_read')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-s-check-circle')
                            ->falseIcon('heroicon-s-bell-alert')
                            ->trueColor('success')
                            ->falseColor('warning')
                            ->grow(false),

                        Tables\Columns\TextColumn::make('created_at')
                            ->label('Waktu Dikirim')
                            ->since()
                            ->dateTimeTooltip()
                            ->color('gray')
                            ->alignment('right'),
                    ]),

                    Tables\Columns\TextColumn::make('message')
                        ->label('Pesan')
                        ->wrap()
                        ->searchable()
                        ->extraAttributes([
                            'class' => 'p-4 rounded-xl bg-gray-900/80 border border-gray-800 text-gray-200 text-sm whitespace-pre-wrap leading-relaxed my-2',
                        ]),
                ])->space(2),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Status Baca')
                    ->placeholder('Semua Pesan')
                    ->trueLabel('Hanya Sudah Dibaca')
                    ->falseLabel('Hanya Belum Dibaca'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $record) => $record->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca')
                    ->icon(fn (ContactMessage $record) => $record->is_read ? 'heroicon-o-arrow-path' : 'heroicon-o-check-circle')
                    ->color(fn (ContactMessage $record) => $record->is_read ? 'gray' : 'success')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => !$record->is_read])),

                Tables\Actions\Action::make('reply')
                    ->label('Balas Email')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('info')
                    ->url(fn (ContactMessage $record) => "mailto:{$record->email}?subject=" . urlencode("Balasan: Pesan Portofolio dari " . $record->name))
                    ->openUrlInNewTab(),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markRead')
                        ->label('Tandai Sudah Dibaca')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
        ];
    }
}
