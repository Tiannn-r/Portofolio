<?php

namespace App\Filament\Pages;

use App\Models\Profile;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageCompetenciesOverview extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationLabel = 'Skills Overview Card';

    protected static ?string $title = 'Pengaturan Kartu Skills Overview (Engineering Focus)';

    protected static ?string $navigationGroup = 'Skills & Competencies';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.manage-competencies-overview';

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Profile::first();
        $overview = $profile?->skills_overview ?? [
            'title' => 'Engineering Scalable & Resilient Systems',
            'description' => 'Fokus pada rekayasa perangkat lunak yang andal, pemeliharaan kode bersih, serta antarmuka interaktif yang cepat dan terukur.',
            'highlights' => [
                ['title' => 'Modern Backend', 'subtitle' => 'Laravel, MySQL, REST API'],
                ['title' => 'Reactive Frontend', 'subtitle' => 'Vue 3, Tailwind CSS'],
            ],
        ];

        $this->form->fill($overview);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kartu Overview Kompetensi (Sisi Kiri My Skills)')
                    ->description('Kelola teks judul, deskripsi, dan kartu-kartu sorotan teknologi (e.g. Modern Backend & Reactive Frontend).')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Utama Kartu')
                            ->required()
                            ->default('Engineering Scalable & Resilient Systems')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi Filosofi Rekayasa')
                            ->rows(3)
                            ->required()
                            ->default('Fokus pada rekayasa perangkat lunak yang andal, pemeliharaan kode bersih, serta antarmuka interaktif yang cepat dan terukur.')
                            ->columnSpanFull(),

                        Repeater::make('highlights')
                            ->label('Daftar Sorotan Fokus (Highlight Cards)')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Label Fokus (e.g. Modern Backend)')
                                    ->required(),
                                TextInput::make('subtitle')
                                    ->label('Rincian Teknologi (e.g. Laravel, MySQL, REST API)')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(2)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $profile = Profile::first();
        if ($profile) {
            $profile->update([
                'skills_overview' => $state,
            ]);
        }

        Notification::make()
            ->title('Kartu Skills Overview Berhasil Diperbarui!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan Overview')
                ->submit('save')
                ->color('primary'),
        ];
    }
}
