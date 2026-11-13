<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Content & Showcase';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Offering')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Layanan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Web Development, UI/UX Design, Desktop Developer'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Layanan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Describe the scope and delivery value of this service...'),
                    ]),

                Forms\Components\Section::make('Ikon Layanan')
                    ->description('Pilih cara memasukkan ikon. Anda bisa copy link CDN (Iconify / Devicon), upload gambar, atau paste kode SVG.')
                    ->schema([
                        Forms\Components\Radio::make('icon_type')
                            ->label('Metode Input Ikon')
                            ->options([
                                'url' => 'Link / URL CDN (Iconify / Devicon / Web)',
                                'upload' => 'Upload File dari Komputer (PNG, SVG, WebP)',
                                'svg' => 'Paste Kode SVG Langsung',
                            ])
                            ->default('url')
                            ->live()
                            ->inline(),

                        Forms\Components\TextInput::make('icon_url')
                            ->label('URL CDN Logo / Ikon')
                            ->placeholder('https://api.iconify.design/heroicons:computer-desktop-solid.svg')
                            ->helperText('Contoh: https://api.iconify.design/heroicons:... atau link CDN lainnya.')
                            ->visible(fn (Forms\Get $get) => $get('icon_type') === 'url' || empty($get('icon_type')))
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('icon_file')
                            ->label('File Ikon Layanan')
                            ->disk('public')
                            ->directory('services')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->helperText('Upload gambar/ikon layanan.')
                            ->visible(fn (Forms\Get $get) => $get('icon_type') === 'upload')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('icon_svg')
                            ->label('Kode Tag <svg>')
                            ->placeholder('<svg xmlns="http://www.w3.org/2000/svg" ...>...</svg>')
                            ->rows(4)
                            ->helperText('Paste kode utuh <svg>...</svg> di sini jika menyalin kode langsung.')
                            ->visible(fn (Forms\Get $get) => $get('icon_type') === 'svg')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('icon')
                    ->label('Ikon')
                    ->view('filament.columns.icon-preview'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Layanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),

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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
