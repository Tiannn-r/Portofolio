<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Get aggregate statistics for CMS Admin Dashboard.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'has_profile' => Profile::exists(),
                'total_projects' => Project::count(),
                'featured_projects' => Project::where('is_featured', true)->count(),
                'total_skills' => Skill::count(),
                'technical_skills' => Skill::where('type', 'grid_icon')->count(),
                'progress_skills' => Skill::where('type', 'progress_bar')->count(),
                'total_services' => Service::count(),
                'total_educations' => Education::where('type', 'education')->count(),
                'total_certifications' => Education::where('type', 'certification')->count(),
                'total_messages' => ContactMessage::count(),
                'unread_messages' => ContactMessage::where('is_read', false)->count(),
                'recent_messages' => ContactMessage::latest()->take(5)->get(),
            ],
        ]);
    }
}
