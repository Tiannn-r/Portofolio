<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Portofolio CMS')
            ->brandLogo(asset('logo.png'))
            ->brandLogoHeight('2.2rem')
            ->favicon(asset('logo.png'))
            ->colors([
                'primary' => [
                    50 => '#f2f8f4',
                    100 => '#daf1de',
                    200 => '#c1e5c8',
                    300 => '#a7d9b2',
                    400 => '#8eb69b',
                    500 => '#5f8f6f',
                    600 => '#3d6c4d',
                    700 => '#235347',
                    800 => '#163832',
                    900 => '#0b2b26',
                    950 => '#051f20',
                ],
                'gray' => Color::Zinc,
            ])
            ->defaultThemeMode(\Filament\Enums\ThemeMode::Dark)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Profil & Identitas',
                'Keahlian & Kompetensi',
                'Portofolio & Karya',
                'Artikel & Cerita',
                'Pendidikan & Sertifikasi',
                'Pesan Masuk',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\PortfolioStatsOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
