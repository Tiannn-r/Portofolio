<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $profile = Profile::first();
        $projectsCount = Project::count();
        $servicesCount = Service::count();
        $skillsCount = Skill::count();
        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Total Projects', $projectsCount)
                ->description(($profile?->projects_completed ?? 0) . ' Completed on record')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('success'),

            Stat::make('Active Services', $servicesCount)
                ->description('Client solutions & offerings')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('primary'),

            Stat::make('Technical Skills', $skillsCount)
                ->description('Stack & Core proficiencies')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),

            Stat::make('Unread Inquiries', $unreadMessagesCount)
                ->description($unreadMessagesCount > 0 ? 'Requires attention' : 'All messages handled')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadMessagesCount > 0 ? 'danger' : 'success'),
        ];
    }
}
