<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request): JsonResponse
    {
        $projects = Project::query()
            ->orderBy('order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:projects,slug',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'thumbnail' => 'nullable', // file or url string
            'tech_stack' => 'required', // array or json string
            'url_demo' => 'nullable|url|max:255',
            'url_repo' => 'nullable|url|max:255',
            'is_featured' => 'nullable',
            'order' => 'nullable|integer',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        // Ensure slug uniqueness
        $baseSlug = $slug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $request->validate(['thumbnail' => 'file|image|mimes:jpeg,png,jpg,webp|max:3072']);
            $thumbnailPath = $request->file('thumbnail')->store('projects', 'public');
        } elseif ($request->filled('thumbnail')) {
            $thumbnailPath = $request->input('thumbnail');
        }

        $techStack = $request->input('tech_stack');
        if (is_string($techStack)) {
            $techStack = json_decode($techStack, true) ?? array_map('trim', explode(',', $techStack));
        }

        $isFeatured = $request->has('is_featured')
            ? filter_var($request->input('is_featured'), FILTER_VALIDATE_BOOLEAN)
            : false;

        $project = Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'thumbnail' => $thumbnailPath,
            'tech_stack' => $techStack,
            'url_demo' => $validated['url_demo'] ?? null,
            'url_repo' => $validated['url_repo'] ?? null,
            'is_featured' => $isFeatured,
            'order' => $validated['order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proyek berhasil ditambahkan!',
            'data' => $project,
        ], 201);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $project,
        ]);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200',
            'slug' => 'sometimes|nullable|string|max:200|unique:projects,slug,' . $project->id,
            'category' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|required|string',
            'thumbnail' => 'nullable',
            'tech_stack' => 'sometimes|nullable',
            'url_demo' => 'nullable|url|max:255',
            'url_repo' => 'nullable|url|max:255',
            'is_featured' => 'nullable',
            'order' => 'sometimes|nullable|integer',
        ]);

        if ($request->hasFile('thumbnail')) {
            $request->validate(['thumbnail' => 'file|image|mimes:jpeg,png,jpg,webp|max:3072']);
            if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $project->thumbnail = $request->file('thumbnail')->store('projects', 'public');
        } elseif ($request->has('thumbnail') && is_string($request->input('thumbnail'))) {
            $project->thumbnail = $request->input('thumbnail');
        }

        if ($request->has('title')) {
            $project->title = $validated['title'];
        }

        if ($request->has('slug')) {
            $newSlug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($project->title);
            $project->slug = $newSlug;
        }

        if ($request->has('category')) $project->category = $validated['category'];
        if ($request->has('description')) $project->description = $validated['description'];

        if ($request->has('tech_stack')) {
            $techStack = $request->input('tech_stack');
            $project->tech_stack = is_string($techStack)
                ? (json_decode($techStack, true) ?? array_map('trim', explode(',', $techStack)))
                : $techStack;
        }

        if ($request->has('url_demo')) $project->url_demo = $request->input('url_demo');
        if ($request->has('url_repo')) $project->url_repo = $request->input('url_repo');

        if ($request->has('is_featured')) {
            $project->is_featured = filter_var($request->input('is_featured'), FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('order')) $project->order = $validated['order'] ?? 0;

        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Proyek berhasil diperbarui!',
            'data' => $project->fresh(),
        ]);
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project): JsonResponse
    {
        if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proyek berhasil dihapus!',
        ]);
    }
}

