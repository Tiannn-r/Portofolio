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

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Content & Showcase';

    protected static ?string $navigationLabel = 'Portfolio Projects';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Overview')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('category')
                            ->required()
                            ->label('Kategori Platform / Tipe Proyek')
                            ->placeholder('Pilih atau ketik kategori (misal: Web Application, Android App, Desktop App)')
                            ->datalist([
                                'Web Application',
                                'Mobile App (Android)',
                                'Desktop Application',
                                'Full-Stack System',
                                'RESTful API & Backend',
                                'UI/UX Design & Prototype',
                            ])
                            ->helperText('Kategori ini akan otomatis menjadi tab filter di halaman portofolio.')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Mark as Featured Case Study')
                            ->helperText('Featured projects are highlighted at the top of the showcase.')
                            ->default(false),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media & Architecture')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('File Thumbnail / Foto Proyek')
                            ->image()
                            ->disk('public')
                            ->directory('projects')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload screenshot atau gambar sampul proyek (PNG/JPG/WebP).')
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('tech_stack')
                            ->label('Technologies & Stack')
                            ->placeholder('Add technology (e.g. Laravel 11, Vue 3, Tailwind CSS)...')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('url_demo')
                            ->label('Demo / Download / Release URL')
                            ->url()
                            ->placeholder('https://... (Website, Play Store, Link APK, Installer .exe, dsb)')
                            ->helperText('Bisa berupa link website live, Google Play Store, link download APK/Installer (GitHub Release/Drive), atau video preview.')
                            ->nullable(),

                        Forms\Components\TextInput::make('url_repo')
                            ->label('Repository URL (GitHub / GitLab)')
                            ->url()
                            ->placeholder('https://github.com/...')
                            ->helperText('Link ke source code proyek.')
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
                    ->label('Thumbnail')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=200&q=80'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('category')
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Status'),
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
