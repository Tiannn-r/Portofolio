<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $modelLabel = 'Proyek';

    protected static ?string $pluralModelLabel = 'Portofolio Proyek';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Portofolio & Karya';

    protected static ?string $navigationLabel = 'Portofolio Proyek';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama Proyek')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Proyek')
                            ->placeholder('Contoh: Aplikasi Kasir POS Android, Sistem Inventaris...')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->helperText('Dibuat otomatis dari judul proyek untuk URL.')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('category')
                            ->required()
                            ->label('Kategori Platform / Tipe Proyek')
                            ->placeholder('Pilih atau ketik kategori (misal: Aplikasi Web, Aplikasi Android, Aplikasi Desktop)')
                            ->datalist([
                                'Aplikasi Web',
                                'Aplikasi Mobile (Android)',
                                'Aplikasi Desktop',
                                'Sistem Full-Stack',
                                'RESTful API & Backend',
                                'Desain UI/UX & Prototipe',
                            ])
                            ->helperText('Kategori ini akan otomatis menjadi tab filter di halaman portofolio.')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tandai sebagai Proyek Unggulan')
                            ->helperText('Proyek unggulan akan disorot di bagian paling atas tampilan portofolio.')
                            ->default(false),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Lengkap Proyek')
                            ->placeholder('Jelaskan latar belakang pembuatan aplikasi, fitur-fitur utama, dan solusi yang dibangun...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media & Arsitektur Teknologi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Foto Sampul / Tangkapan Layar (Thumbnail)')
                            ->image()
                            ->disk('public')
                            ->directory('projects')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Unggah tangkapan layar antarmuka atau gambar sampul proyek (PNG, JPG, atau WebP).')
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('tech_stack')
                            ->label('Teknologi & Tech Stack')
                            ->placeholder('Ketik teknologi lalu Enter (misal: Kotlin, Laravel 11, Vue 3, Tailwind CSS)...')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('url_demo')
                            ->label('Tautan Demo / Unduh / Rilis (Live Demo)')
                            ->url()
                            ->placeholder('https://... (Website, Play Store, Link APK, Installer .exe, dsb)')
                            ->helperText('Bisa berupa link website aktif, Google Play Store, link download APK/Installer (GitHub Release/Drive), atau video preview.')
                            ->nullable(),

                        Forms\Components\TextInput::make('url_repo')
                            ->label('Tautan Repository (GitHub / GitLab)')
                            ->url()
                            ->placeholder('https://github.com/...')
                            ->helperText('Tautan ke source code repository proyek.')
                            ->nullable(),

                        Forms\Components\Hidden::make('order')
                            ->default(0),
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
                    ->label('Sampul')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=200&q=80'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Proyek')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Status Unggulan'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
