<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index(): JsonResponse
    {
        $skills = Skill::query()->orderBy('order')->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $skills,
        ]);
    }

    /**
     * Store a newly created skill.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'percentage' => 'required|integer|min:0|max:100',
            'type' => 'required|in:grid_icon,progress_bar',
            'icon' => 'nullable', // string or uploaded file
            'order' => 'nullable|integer',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $request->validate(['icon' => 'file|image|mimes:jpeg,png,jpg,webp,svg|max:1024']);
            $iconPath = $request->file('icon')->store('skills', 'public');
        } elseif ($request->filled('icon')) {
            $iconPath = $request->input('icon');
        }

        $skill = Skill::create([
            'name' => $validated['name'],
            'icon' => $iconPath,
            'percentage' => $validated['percentage'],
            'type' => $validated['type'],
            'order' => $validated['order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Skill berhasil ditambahkan!',
            'data' => $skill,
        ], 201);
    }

    /**
     * Display the specified skill.
     */
    public function show(Skill $skill): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $skill,
        ]);
    }

    /**
     * Update the specified skill.
     */
    public function update(Request $request, Skill $skill): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'percentage' => 'sometimes|required|integer|min:0|max:100',
            'type' => 'sometimes|required|in:grid_icon,progress_bar',
            'icon' => 'nullable',
            'order' => 'sometimes|nullable|integer',
        ]);

        if ($request->hasFile('icon')) {
            $request->validate(['icon' => 'file|image|mimes:jpeg,png,jpg,webp,svg|max:1024']);
            if ($skill->icon && Storage::disk('public')->exists($skill->icon)) {
                Storage::disk('public')->delete($skill->icon);
            }
            $skill->icon = $request->file('icon')->store('skills', 'public');
        } elseif ($request->has('icon') && is_string($request->input('icon'))) {
            $skill->icon = $request->input('icon');
        }

        if ($request->has('name')) $skill->name = $validated['name'];
        if ($request->has('percentage')) $skill->percentage = $validated['percentage'];
        if ($request->has('type')) $skill->type = $validated['type'];
        if ($request->has('order')) $skill->order = $validated['order'] ?? 0;

        $skill->save();

        return response()->json([
            'success' => true,
            'message' => 'Skill berhasil diperbarui!',
            'data' => $skill->fresh(),
        ]);
    }

    /**
     * Remove the specified skill.
     */
    public function destroy(Skill $skill): JsonResponse
    {
        if ($skill->icon && Storage::disk('public')->exists($skill->icon)) {
            Storage::disk('public')->delete($skill->icon);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill berhasil dihapus!',
        ]);
    }
}

