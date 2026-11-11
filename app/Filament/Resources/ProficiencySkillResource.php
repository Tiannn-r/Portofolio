<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProficiencySkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProficiencySkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Skills & Competencies';

    protected static ?string $navigationLabel = 'My Skills (Progress Bars)';

    protected static ?string $modelLabel = 'Skill Proficiency';

    protected static ?string $pluralModelLabel = 'My Skills (Progress Bars)';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('type', ['progress_bar', 'bar']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Competency & Proficiency')
                    ->description('Bidang kompetensi yang ditampilkan sebagai horizontal progress bar di bagian Competencies.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kompetensi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Backend Architecture & API Development')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('percentage')
                            ->label('Tingkat Kemahiran (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->suffix('%')
                            ->default(85)
                            ->required(),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Hidden::make('type')
                            ->default('progress_bar'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kompetensi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('percentage')
                    ->label('Persentase')
                    ->suffix('%')
                    ->sortable(),

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
            'index' => Pages\ListProficiencySkills::route('/'),
            'create' => Pages\CreateProficiencySkill::route('/create'),
            'edit' => Pages\EditProficiencySkill::route('/{record}/edit'),
        ];
    }
}
