<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of educations and certifications.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Education::query()->orderBy('order')->orderByDesc('id');

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        return response()->json([
            'success' => true,
            'data' => $query->get(),
        ]);
    }

    /**
     * Store a newly created education/certification record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'institution' => 'required|string|max:150',
            'period' => 'required|string|max:100',
            'description' => 'nullable|string',
            'type' => 'required|in:education,certification',
            'order' => 'nullable|integer',
        ]);

        $education = Education::create([
            'title' => $validated['title'],
            'institution' => $validated['institution'],
            'period' => $validated['period'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'order' => $validated['order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pendidikan / sertifikasi berhasil ditambahkan!',
            'data' => $education,
        ], 201);
    }

    /**
     * Display the specified education record.
     */
    public function show(Education $education): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $education,
        ]);
    }

    /**
     * Update the specified education record.
     */
    public function update(Request $request, Education $education): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:150',
            'institution' => 'sometimes|required|string|max:150',
            'period' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'type' => 'sometimes|required|in:education,certification',
            'order' => 'sometimes|nullable|integer',
        ]);

        $education->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data pendidikan / sertifikasi berhasil diperbarui!',
            'data' => $education->fresh(),
        ]);
    }

    /**
     * Remove the specified education record.
     */
    public function destroy(Education $education): JsonResponse
    {
        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pendidikan / sertifikasi berhasil dihapus!',
        ]);
    }
}

