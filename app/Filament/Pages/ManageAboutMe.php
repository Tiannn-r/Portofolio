<?php

namespace App\Filament\Pages;

use App\Models\Profile;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageAboutMe extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'About Me & Profile';

    protected static ?string $title = 'Edit About Me & Profile';

    protected static ?string $navigationGroup = 'Portfolio Profile';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-about-me';

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Profile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Muhamad Ibnhu',
                'roles' => ['Full-Stack Developer', 'Backend Specialist', 'UI/UX Enthusiast'],
                'short_bio' => 'Passionate Full-Stack Developer crafting scalable web applications.',
                'about_me' => 'Halo! Saya adalah seorang Full-Stack Developer yang berdedikasi membangun produk modern.',
                'is_available' => true,
                'email' => 'ibnhu.work@gmail.com',
                'phone' => '+62 812-3456-7890',
                'location' => 'Jakarta, Indonesia',
                'happy_clients' => 18,
                'projects_completed' => 24,
                'years_experience' => 3,
                'awards_received' => 5,
            ]
        );

        $this->form->fill($profile->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Identity & Availability')
                    ->description('Kelola identitas utama, ketersediaan freelance, kontak, dan lokasi.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_available')
                            ->label('Status Tersedia Freelance')
                            ->helperText('Menampilkan badge hijau aktif di Hero section')
                            ->inline(false)
                            ->default(true),

                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Nomor WhatsApp / Telepon')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->placeholder('Jakarta, Indonesia')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Profil & File Dokumen CV')
                    ->description('Upload foto khusus landing page hero, foto khusus about me, dan file dokumen CV resmi (PDF/Word).')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('hero_image')
                            ->label('Foto Landing Page (Hero Section)')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Upload foto profil untuk bagian paling atas / landing page (Hero).'),

                        FileUpload::make('about_image')
                            ->label('Foto Section About Me')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Upload foto profil khusus untuk kartu About Me.'),

                        FileUpload::make('cv_file')
                            ->label('File Dokumen CV / Resume (PDF / DOCX)')
                            ->disk('public')
                            ->directory('documents')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ])
                            ->helperText('Upload file berkas CV Anda. Tombol "Download CV" di web akan langsung mendownload file ini.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Peran & Narasi Tentang Saya (About Me)')
                    ->description('Kelola teks animasi role typing, bio ringkas hero, dan cerita lengkap pada kartu About Me.')
                    ->schema([
                        TagsInput::make('roles')
                            ->label('Daftar Role / Spesialisasi (Animasi Mengetik Hero)')
                            ->placeholder('Ketik role lalu tekan Enter (e.g. Full-Stack Developer)...')
                            ->required(),

                        Textarea::make('short_bio')
                            ->label('Deskripsi Singkat (Hero Section)')
                            ->rows(3)
                            ->required(),

                        Textarea::make('about_me')
                            ->label('Narasi Lengkap About Me')
                            ->rows(6)
                            ->helperText('Paragraf lengkap yang ditampilkan pada kartu About Me dan modal cerita Anda.')
                            ->required(),
                    ]),

                Section::make('Tautan Media Sosial')
                    ->description('Profil GitHub, LinkedIn, Twitter, Instagram, dll.')
                    ->schema([
                        KeyValue::make('social_links')
                            ->label('Social Media Platforms')
                            ->keyLabel('Nama Platform (github, linkedin, instagram, twitter)')
                            ->valueLabel('URL Lengkap Profil')
                            ->columnSpanFull(),
                    ]),

                Section::make('Metrik & Angka Pencapaian')
                    ->description('Angka statistik yang tampil pada baris Hero dan Dashboard.')
                    ->columns(4)
                    ->schema([
                        TextInput::make('years_experience')
                            ->label('Years Experience')
                            ->numeric()
                            ->required(),

                        TextInput::make('projects_completed')
                            ->label('Projects Done')
                            ->numeric()
                            ->required(),

                        TextInput::make('happy_clients')
                            ->label('Happy Clients')
                            ->numeric()
                            ->required(),

                        TextInput::make('awards_received')
                            ->label('Awards / Certs')
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $profile = Profile::first();
        if ($profile) {
            $profile->update($state);
        } else {
            Profile::create($state);
        }

        Notification::make()
            ->title('Data About Me & Profil Berhasil Disimpan!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save')
                ->color('primary'),
        ];
    }
}
