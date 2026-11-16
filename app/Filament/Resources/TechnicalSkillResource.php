<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnicalSkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TechnicalSkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Skills & Competencies';

    protected static ?string $navigationLabel = 'Technical Skills (Grid)';

    protected static ?string $modelLabel = 'Technical Skill';

    protected static ?string $pluralModelLabel = 'Technical Skills (Grid)';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('type', ['grid_icon', 'technical_grid']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Teknologi')
                    ->description('Keahlian teknologi yang ditampilkan berupa logo dan nama di samping kartu About Me.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Teknologi / Framework')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Laravel, Vue.js 3, MySQL, Tailwind CSS')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('order')
                            ->default(0),

                        Forms\Components\Hidden::make('type')
                            ->default('grid_icon'),

                        Forms\Components\Hidden::make('percentage')
                            ->default(100),
                    ]),

                Forms\Components\Section::make('Logo / Ikon Teknologi')
                    ->description('Pilih cara memasukkan ikon. Anda bisa copy link CDN langsung dari devicon.dev, upload gambar, atau paste kode SVG.')
                    ->schema([
                        Forms\Components\Radio::make('icon_type')
                            ->label('Metode Input Ikon')
                            ->options([
                                'url' => 'Link / URL CDN (Rekomendasi devicon.dev)',
                                'upload' => 'Upload File dari Komputer (PNG, SVG, WebP)',
                                'svg' => 'Paste Kode SVG Langsung',
                            ])
                            ->default('url')
                            ->live()
                            ->inline(),

                        Forms\Components\TextInput::make('icon_url')
                            ->label('URL CDN Logo / Ikon')
                            ->placeholder('https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg')
                            ->helperText('Buka devicon.dev, pilih ikon, copy link CDN dan paste di sini.')
                            ->visible(fn (Forms\Get $get) => $get('icon_type') === 'url' || empty($get('icon_type')))
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('icon_file')
                            ->label('File Logo / Ikon')
                            ->disk('public')
                            ->directory('skills')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->helperText('Upload file logo teknologi (PNG, SVG, atau WebP).')
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
                Tables\Columns\ViewColumn::make('icon')
                    ->label('Logo')
                    ->view('filament.columns.icon-preview'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Teknologi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

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
            'index' => Pages\ListTechnicalSkills::route('/'),
            'create' => Pages\CreateTechnicalSkill::route('/create'),
            'edit' => Pages\EditTechnicalSkill::route('/{record}/edit'),
        ];
    }
}
