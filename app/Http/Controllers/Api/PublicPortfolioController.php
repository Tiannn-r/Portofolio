<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicPortfolioController extends Controller
{
    /**
     * Get all portfolio data in one response for efficient Vue 3 landing page load.
     */
    public function all(): JsonResponse
    {
        $profile = Profile::query()->first();
        $skills = Skill::query()->orderBy('order')->orderBy('id')->get();
        $services = Service::query()->orderBy('order')->orderBy('id')->get();
        $featuredProjects = Project::query()->where('is_featured', true)->orderBy('order')->orderByDesc('id')->get();
        $allProjects = Project::query()->orderBy('order')->orderByDesc('id')->get();
        $educations = Education::query()->where('type', 'education')->orderBy('order')->orderByDesc('id')->get();
        $certifications = Education::query()->where('type', 'certification')->orderBy('order')->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => $profile,
                'skills' => [
                    'all' => $skills,
                    'technical_grid' => $skills->where('type', 'grid_icon')->values(),
                    'progress_bars' => $skills->where('type', 'progress_bar')->values(),
                ],
                'services' => $services,
                'featured_projects' => $featuredProjects,
                'projects' => $allProjects,
                'educations' => $educations,
                'certifications' => $certifications,
            ],
        ]);
    }

    /**
     * Get profile information.
     */
    public function profile(): JsonResponse
    {
        $profile = Profile::query()->first();

        return response()->json([
            'success' => true,
            'data' => $profile,
        ]);
    }

    /**
     * Get list of skills.
     */
    public function skills(): JsonResponse
    {
        $skills = Skill::query()->orderBy('order')->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'technical_grid' => $skills->where('type', 'grid_icon')->values(),
                'progress_bars' => $skills->where('type', 'progress_bar')->values(),
                'all' => $skills,
            ],
        ]);
    }

    /**
     * Get list of services.
     */
    public function services(): JsonResponse
    {
        $services = Service::query()->orderBy('order')->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    /**
     * Get projects with optional category and featured filter.
     */
    public function projects(Request $request): JsonResponse
    {
        $query = Project::query()->orderBy('order')->orderByDesc('id');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        if ($request->has('featured')) {
            $query->where('is_featured', filter_var($request->query('featured'), FILTER_VALIDATE_BOOLEAN));
        }

        $projects = $query->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    /**
     * Get project details by slug.
     */
    public function projectDetail(string $slug): JsonResponse
    {
        $project = Project::query()->where('slug', $slug)->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project,
        ]);
    }

    /**
     * Get education and certification records.
     */
    public function educations(): JsonResponse
    {
        $records = Education::query()->orderBy('order')->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'educations' => $records->where('type', 'education')->values(),
                'certifications' => $records->where('type', 'certification')->values(),
                'all' => $records,
            ],
        ]);
    }

    /**
     * Handle contact message submission from public visitors.
     */
    public function sendContactMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'message' => 'required|string|max:3000',
        ]);

        $message = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, pesan Anda telah berhasil dikirim!',
            'data' => $message,
        ], 201);
    }
}
