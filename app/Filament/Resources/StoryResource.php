<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Models\Story;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Artikel & Cerita';

    protected static ?string $navigationLabel = 'Artikel & Cerita';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel & Cerita';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita / Cerita')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Berita / Cerita')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('category')
                            ->label('Kategori / Jenis Berita')
                            ->required()
                            ->placeholder('e.g. Pencapaian, Kegiatan & Berbagi, Inovasi & Open Source')
                            ->default('Pencapaian'),

                        Forms\Components\TextInput::make('event_date')
                            ->label('Waktu / Tanggal Pelaksanaan')
                            ->placeholder('e.g. Oktober 2026')
                            ->default(now()->format('F Y')),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Showcase Berita')
                            ->default(true),

                        Forms\Components\Hidden::make('order')
                            ->default(0),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('File Gambar / Foto Berita')
                            ->image()
                            ->disk('public')
                            ->directory('stories')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload foto kegiatan, dokumentasi, atau gambar pendukung berita.')
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('tags')
                            ->label('Tag Topik')
                            ->placeholder('Ketik tag lalu tekan enter...')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('summary')
                            ->label('Ringkasan Singkat (Muncul di Slider)')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('content')
                            ->label('Narasi Lengkap Cerita / Berita (Muncul saat Read Story diklik)')
                            ->rows(6)
                            ->required()
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
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Foto')
                    ->square()
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(45),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

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
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}

