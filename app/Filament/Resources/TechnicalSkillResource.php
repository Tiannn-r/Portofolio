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
                Forms\Components\Section::make('Technical Skill (Logo & Nama)')
                    ->description('Keahlian teknologi yang ditampilkan berupa logo dan nama di samping kartu About Me.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Teknologi / Framework')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Laravel, Vue.js 3, MySQL, Tailwind CSS'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\FileUpload::make('icon')
                            ->label('File Logo / Ikon')
                            ->image()
                            ->disk('public')
                            ->directory('skills')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload file logo teknologi (PNG, SVG, atau WebP).')
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\Hidden::make('type')
                            ->default('grid_icon'),

                        Forms\Components\Hidden::make('percentage')
                            ->default(100),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('Logo')
                    ->disk('public')
                    ->defaultImageUrl(fn (Skill $record) => $record->icon_url)
                    ->square()
                    ->size(36),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Teknologi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

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
            'index' => Pages\ListTechnicalSkills::route('/'),
            'create' => Pages\CreateTechnicalSkill::route('/create'),
            'edit' => Pages\EditTechnicalSkill::route('/{record}/edit'),
        ];
    }
}
