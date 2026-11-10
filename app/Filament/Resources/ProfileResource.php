<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Portfolio Setup';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Profile')
                    ->description('Personal identification, contact information, and availability status.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_available')
                            ->label('Available for Freelance Projects')
                            ->inline(false)
                            ->default(true),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('avatar')
                            ->label('Avatar Image URL / Path')
                            ->placeholder('https://... or /storage/...'),
                        Forms\Components\TextInput::make('cv_file')
                            ->label('CV File URL / Path')
                            ->placeholder('/files/CV-Muhamad-Ibnhu.pdf'),
                    ]),

                Forms\Components\Section::make('Bio & Presentation')
                    ->description('Headlines, role tags, and introduction narrative.')
                    ->schema([
                        Forms\Components\TagsInput::make('roles')
                            ->label('Role Titles (Shown in Typing Animation)')
                            ->placeholder('Add a role...')
                            ->required(),
                        Forms\Components\Textarea::make('short_bio')
                            ->label('Hero Short Bio')
                            ->rows(3)
                            ->required(),
                        Forms\Components\Textarea::make('about_me')
                            ->label('Full About Me Narrative')
                            ->rows(5)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Social Links & Profiles')
                    ->description('External portfolio, code repositories, and networking profiles.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\KeyValue::make('social_links')
                            ->keyLabel('Platform (e.g. github, linkedin)')
                            ->valueLabel('Profile URL')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Key Metrics & Counter Statistics')
                    ->description('Displayed in the Hero stat row and Admin dashboard banner.')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('years_experience')
                            ->label('Years of Experience')
                            ->numeric()
                            ->default(3)
                            ->required(),
                        Forms\Components\TextInput::make('projects_completed')
                            ->label('Projects Completed')
                            ->numeric()
                            ->default(24)
                            ->required(),
                        Forms\Components\TextInput::make('happy_clients')
                            ->label('Happy Clients')
                            ->numeric()
                            ->default(18)
                            ->required(),
                        Forms\Components\TextInput::make('awards_received')
                            ->label('Awards / Certs')
                            ->numeric()
                            ->default(5)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('projects_completed')
                    ->label('Projects')
                    ->numeric(),
                Tables\Columns\TextColumn::make('years_experience')
                    ->label('Exp (Yrs)')
                    ->numeric(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
