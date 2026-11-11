<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic & Credentials';

    protected static ?string $navigationLabel = 'Formal Education';

    protected static ?string $modelLabel = 'Formal Education';

    protected static ?string $pluralModelLabel = 'Formal Education';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'education');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pendidikan Formal')
                    ->description('Gelar akademik, universitas/sekolah, dan konsentrasi studi.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Gelar / Jenjang Studi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. S1 Teknik Informatika'),

                        Forms\Components\TextInput::make('institution')
                            ->label('Universitas / Institusi Pendidikan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Universitas Bina Nusantara'),

                        Forms\Components\TextInput::make('period')
                            ->label('Tahun / Periode Studi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. 2020 - 2024'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan / Fokus Spesialisasi')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Fokus bidang keilmuan, skripsi/tugas akhir, atau predikat kelulusan...'),

                        Forms\Components\Hidden::make('type')
                            ->default('education'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Jenjang & Jurusan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('institution')
                    ->label('Institusi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('period')
                    ->label('Periode')
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
