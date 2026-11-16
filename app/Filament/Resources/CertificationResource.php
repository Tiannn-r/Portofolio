<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificationResource\Pages;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CertificationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Academic & Credentials';

    protected static ?string $navigationLabel = 'Certifications & Credentials';

    protected static ?string $modelLabel = 'Certification';

    protected static ?string $pluralModelLabel = 'Certifications';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'certification');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Sertifikasi & Kredensial')
                    ->description('Kelola detail sertifikat yang dapat diklik pengunjung untuk melihat gambar, event, tanggal perolehan, dan riwayatnya.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Sertifikat')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Google Certified Cloud Digital Leader')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('institution')
                            ->label('Institusi / Lembaga Penerbit')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Google Cloud, Dicoding Indonesia, Laravel LLC'),

                        Forms\Components\TextInput::make('event_name')
                            ->label('Keterangan Event / Ujian Sertifikasi')
                            ->placeholder('e.g. Google Cloud Global Examination 2024')
                            ->helperText('Nama event kompetisi, bootcamp, atau ujian kelulusan'),

                        Forms\Components\TextInput::make('period')
                            ->label('Kapan Didapatkan (Waktu / Masa Berlaku)')
                            ->required()
                            ->placeholder('e.g. November 2024 atau 2024 - 2027'),

                        Forms\Components\TextInput::make('credential_url')
                            ->label('Link Verifikasi Sertifikat (Opsional)')
                            ->url()
                            ->placeholder('https://...')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('order')
                            ->default(0),

                        Forms\Components\FileUpload::make('certificate_image')
                            ->label('File Gambar Sertifikat (Preview Saat Diklik)')
                            ->image()
                            ->disk('public')
                            ->directory('certificates')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload foto / scan dokumen sertifikat (PNG/JPG/WebP). Gambar ini akan ditampilkan saat sertifikat diklik oleh pengunjung.')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Ringkas (Tampil di Kartu)')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Ringkasan cakupan keahlian sertifikasi...'),

                        Forms\Components\Textarea::make('history')
                            ->label('History & Cerita Proses Mendapatkannya (Tampil di Modal)')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Ceritakan pengalaman, tantangan, atau proyek yang diselesaikan untuk meraih sertifikat ini...'),

                        Forms\Components\Hidden::make('type')
                            ->default('certification'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->reorderRecordsTriggerAction(
                fn (Tables\Actions\Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? 'Selesai Mengurutkan' : 'Urutkan (Tarik / Drag)')
                    ->icon($isReordering ? 'heroicon-m-check' : 'heroicon-m-arrows-up-down')
                    ->color($isReordering ? 'success' : 'primary')
            )
            ->defaultSort('order', 'asc')
            ->paginated([10, 25, 50, 'all'])
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\ImageColumn::make('certificate_image_url')
                    ->label('Sertifikat')
                    ->square()
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Sertifikat')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),

                Tables\Columns\TextColumn::make('institution')
                    ->label('Penerbit')
                    ->searchable(),

                Tables\Columns\TextColumn::make('event_name')
                    ->label('Event')
                    ->limit(25),

                Tables\Columns\TextColumn::make('period')
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}

