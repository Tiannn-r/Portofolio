<?php

namespace App\Filament\Pages;

use App\Models\Profile;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

        $formData = $profile->toArray();

        // Ensure email and phone have reliable fallback values
        $formData['email'] = $profile->email ?: 'ibnhu.work@gmail.com';
        $formData['phone'] = $profile->phone ?: '+62 812-3456-7890';

        // Load social_links cleanly into dedicated settings fields
        $social = $profile->social_links ?? [];

        if (is_array($social)) {
            // Check if it's a numeric list from legacy Repeater
            if (!empty($social) && array_keys($social) === range(0, count($social) - 1)) {
                $customs = [];
                foreach ($social as $item) {
                    $plat = strtolower($item['name'] ?? $item['platform'] ?? '');
                    if ($plat === 'linkedin') {
                        $formData['linkedin_url'] = $item['url'] ?? '';
                        $formData['linkedin_subtext'] = $item['subtext'] ?? 'Terhubung Profesional';
                    } elseif ($plat === 'github') {
                        $formData['github_url'] = $item['url'] ?? '';
                    } elseif ($plat === 'tiktok') {
                        $formData['tiktok_url'] = $item['url'] ?? '';
                    } elseif ($plat === 'youtube') {
                        $formData['youtube_url'] = $item['url'] ?? '';
                    } elseif ($plat === 'instagram') {
                        $formData['instagram_url'] = $item['url'] ?? '';
                    } elseif ($plat === 'twitter' || $plat === 'x') {
                        $formData['twitter_url'] = $item['url'] ?? '';
                    } elseif ($plat === 'whatsapp') {
                        $formData['whatsapp_subtext'] = $item['subtext'] ?? 'Chat & Diskusi Cepat';
                    } elseif ($plat === 'email' || $plat === 'gmail') {
                        $formData['email_subtext'] = $item['subtext'] ?? 'Kirim Pesan Langsung';
                    } else {
                        $customs[] = $item;
                    }
                }
                $formData['custom_channels'] = $customs;
            } else {
                // Key-value or associative format
                $formData['linkedin_url'] = $social['linkedin_url'] ?? ($social['linkedin'] ?? '');
                $formData['linkedin_subtext'] = $social['linkedin_subtext'] ?? 'Terhubung Profesional';

                $formData['email_subtext'] = $social['email_subtext'] ?? 'Kirim Pesan Langsung';
                $formData['whatsapp_subtext'] = $social['whatsapp_subtext'] ?? 'Chat & Diskusi Cepat';

                $formData['github_url'] = $social['github_url'] ?? ($social['github'] ?? '');
                $formData['tiktok_url'] = $social['tiktok_url'] ?? ($social['tiktok'] ?? '');
                $formData['youtube_url'] = $social['youtube_url'] ?? ($social['youtube'] ?? '');
                $formData['instagram_url'] = $social['instagram_url'] ?? ($social['instagram'] ?? '');
                $formData['twitter_url'] = $social['twitter_url'] ?? ($social['twitter'] ?? ($social['x'] ?? ''));

                $formData['custom_channels'] = $social['custom_channels'] ?? [];
            }
        }

        // Apply defaults if still empty
        $formData['linkedin_subtext'] = !empty($formData['linkedin_subtext']) ? $formData['linkedin_subtext'] : 'Terhubung Profesional';
        $formData['email_subtext'] = !empty($formData['email_subtext']) ? $formData['email_subtext'] : 'Kirim Pesan Langsung';
        $formData['whatsapp_subtext'] = !empty($formData['whatsapp_subtext']) ? $formData['whatsapp_subtext'] : 'Chat & Diskusi Cepat';

        $this->form->fill($formData);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Utama & Ketersediaan')
                    ->description('Kelola identitas utama, ketersediaan freelance, dan lokasi domisili.')
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

                        TextInput::make('location')
                            ->label('Lokasi Domisili')
                            ->placeholder('Jakarta, Indonesia')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Profil & File Dokumen CV')
                    ->description('Upload foto khusus landing page hero, foto khusus about me, dan file berkas dokumen CV resmi (PDF/Word).')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('hero_image')
                            ->label('Foto Landing Page (Hero Section)')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload foto profil untuk bagian paling atas / landing page (Hero).'),

                        FileUpload::make('about_image')
                            ->label('Foto Section About Me')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload foto profil khusus untuk kartu About Me.'),

                        FileUpload::make('cv_file')
                            ->label('File Dokumen CV / Resume (PDF / DOCX)')
                            ->disk('public')
                            ->directory('documents')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ])
                            ->helperText('Upload berkas CV Anda. Tombol "Unduh CV" di web akan langsung mengunduh file ini.')
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

                Section::make('Saluran Kontak Formal (Di Bawah Form Kontak)')
                    ->description('3 Saluran kontak resmi yang tampil rapi dalam kartu persegi panjang berjejer ke kanan di bawah form kirim pesan (Email, WhatsApp, LinkedIn).')
                    ->columns(3)
                    ->schema([
                        TextInput::make('email')
                            ->label('Alamat Email (Gmail)')
                            ->email()
                            ->placeholder('ibnhu.work@gmail.com')
                            ->required()
                            ->helperText('Email tujuan saat pengunjung mengklik kartu Email'),

                        TextInput::make('phone')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->placeholder('+62 812-3456-7890')
                            ->required()
                            ->helperText('Nomor WA tujuan (mendukung format 08xxx atau +62xxx)'),

                        TextInput::make('linkedin_url')
                            ->label('URL Profil LinkedIn')
                            ->placeholder('https://linkedin.com/in/muhamad-ibnhu')
                            ->helperText('Tautan ke halaman profil LinkedIn Anda'),
                    ]),

                Section::make('Media Sosial Developer (Khusus di Footer)')
                    ->description('Tautan media sosial dan repositori publik yang tampil rapi dengan ikon modern di bagian Footer website.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('github_url')
                            ->label('URL Profil GitHub')
                            ->placeholder('https://github.com/Tiannn-r'),

                        TextInput::make('tiktok_url')
                            ->label('URL Profil TikTok')
                            ->placeholder('https://tiktok.com/@zydlucifer'),

                        TextInput::make('instagram_url')
                            ->label('URL Profil Instagram')
                            ->placeholder('https://instagram.com/nukaien'),

                        TextInput::make('twitter_url')
                            ->label('URL Profil Twitter / X')
                            ->placeholder('https://x.com/tiannn'),

                        TextInput::make('youtube_url')
                            ->label('URL Channel YouTube')
                            ->placeholder('https://youtube.com/@channel')
                            ->columnSpanFull(),
                    ]),

                Section::make('Saluran Tambahan / Kustom (Bebas Tambah Kontak atau Medsos Baru)')
                    ->description('Tambahkan kontak baru atau media sosial lain (seperti Discord, Telegram, Behance, Dribbble) dengan opsi import logo (bisa via Link URL atau Upload file gambar).')
                    ->schema([
                        Repeater::make('custom_channels')
                            ->label('Daftar Saluran Kustom Tambahan')
                            ->itemLabel(fn (array $state): ?string => ($state['name'] ?? 'Saluran Baru') . ' [' . (($state['category'] ?? 'social') === 'formal' ? 'Kontak Formal' : 'Media Sosial') . ']')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('name')
                                        ->label('Nama Platform / Saluran')
                                        ->placeholder('Contoh: Telegram, Discord, Behance')
                                        ->required(),

                                    Select::make('category')
                                        ->label('Penempatan')
                                        ->options([
                                            'formal' => 'Kontak Formal (Di Bawah Form Kontak)',
                                            'social' => 'Media Sosial (Di Bagian Footer)',
                                        ])
                                        ->default('social')
                                        ->required(),

                                    TextInput::make('url')
                                        ->label('URL Tautan')
                                        ->placeholder('https://...')
                                        ->required(),
                                ]),

                                Grid::make(3)->schema([
                                    TextInput::make('subtext')
                                        ->label('Keterangan Singkat (Untuk Kontak Formal)')
                                        ->placeholder('Contoh: Komunitas Developer, Chat Cepat')
                                        ->columnSpan(1),

                                    Select::make('logo_source')
                                        ->label('Pilihan Logo / Ikon')
                                        ->options([
                                            'preset' => 'Ikon Bawaan (Otomatis dari Nama)',
                                            'url' => 'Input Link URL Gambar / SVG Logo',
                                            'upload' => 'Upload File Gambar / Logo Sendiri',
                                        ])
                                        ->default('preset')
                                        ->reactive()
                                        ->columnSpan(1),

                                    TextInput::make('logo_url')
                                        ->label('Link URL Gambar / SVG Logo')
                                        ->placeholder('https://domain.com/icon.svg')
                                        ->visible(fn ($get) => $get('logo_source') === 'url')
                                        ->columnSpan(1),

                                    FileUpload::make('logo_file')
                                        ->label('Upload File Gambar / Logo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('social_icons')
                                        ->visibility('public')
                                        ->visible(fn ($get) => $get('logo_source') === 'upload')
                                        ->columnSpan(1),
                                ]),
                            ])
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->collapsed(false)
                            ->addActionLabel('+ Tambah Saluran / Medsos Baru')
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
        if (!$profile) {
            $profile = new Profile();
        }

        // Pack social_links cleanly for frontend and future compatibility
        $socialLinks = [
            // Formal Contact Details
            'linkedin' => $state['linkedin_url'] ?? '',
            'linkedin_url' => $state['linkedin_url'] ?? '',
            'linkedin_subtext' => $state['linkedin_subtext'] ?? 'Terhubung Profesional',
            'email_subtext' => $state['email_subtext'] ?? 'Kirim Pesan Langsung',
            'whatsapp_subtext' => $state['whatsapp_subtext'] ?? 'Chat & Diskusi Cepat',

            // Footer Socials
            'github' => $state['github_url'] ?? '',
            'github_url' => $state['github_url'] ?? '',
            'tiktok' => $state['tiktok_url'] ?? '',
            'tiktok_url' => $state['tiktok_url'] ?? '',
            'instagram' => $state['instagram_url'] ?? '',
            'instagram_url' => $state['instagram_url'] ?? '',
            'twitter' => $state['twitter_url'] ?? '',
            'twitter_url' => $state['twitter_url'] ?? '',
            'youtube' => $state['youtube_url'] ?? '',
            'youtube_url' => $state['youtube_url'] ?? '',

            // Custom Channels Repeater
            'custom_channels' => $state['custom_channels'] ?? [],
        ];

        $updateData = [
            'name' => $state['name'],
            'is_available' => (bool) ($state['is_available'] ?? true),
            'location' => $state['location'] ?? null,
            'email' => $state['email'] ?? null,
            'phone' => $state['phone'] ?? null,
            'hero_image' => $state['hero_image'] ?? null,
            'about_image' => $state['about_image'] ?? null,
            'cv_file' => $state['cv_file'] ?? null,
            'roles' => $state['roles'] ?? [],
            'short_bio' => $state['short_bio'] ?? '',
            'about_me' => $state['about_me'] ?? '',
            'social_links' => $socialLinks,
            'years_experience' => (int) ($state['years_experience'] ?? 0),
            'projects_completed' => (int) ($state['projects_completed'] ?? 0),
            'happy_clients' => (int) ($state['happy_clients'] ?? 0),
            'awards_received' => (int) ($state['awards_received'] ?? 0),
        ];

        $profile->fill($updateData);
        $profile->save();

        Notification::make()
            ->title('Data About Me & Pengaturan Kontak Berhasil Disimpan!')
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
