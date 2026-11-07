<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(): JsonResponse
    {
        $services = Service::query()->orderBy('order')->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'icon' => 'nullable',
            'order' => 'nullable|integer',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $request->validate(['icon' => 'file|image|mimes:jpeg,png,jpg,webp,svg|max:1024']);
            $iconPath = $request->file('icon')->store('services', 'public');
        } elseif ($request->filled('icon')) {
            $iconPath = $request->input('icon');
        }

        $service = Service::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $iconPath,
            'order' => $validated['order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil ditambahkan!',
            'data' => $service,
        ], 201);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:150',
            'description' => 'sometimes|required|string',
            'icon' => 'nullable',
            'order' => 'sometimes|nullable|integer',
        ]);

        if ($request->hasFile('icon')) {
            $request->validate(['icon' => 'file|image|mimes:jpeg,png,jpg,webp,svg|max:1024']);
            if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                Storage::disk('public')->delete($service->icon);
            }
            $service->icon = $request->file('icon')->store('services', 'public');
        } elseif ($request->has('icon') && is_string($request->input('icon'))) {
            $service->icon = $request->input('icon');
        }

        if ($request->has('title')) $service->title = $validated['title'];
        if ($request->has('description')) $service->description = $validated['description'];
        if ($request->has('order')) $service->order = $validated['order'] ?? 0;

        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil diperbarui!',
            'data' => $service->fresh(),
        ]);
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service): JsonResponse
    {
        if ($service->icon && Storage::disk('public')->exists($service->icon)) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus!',
        ]);
    }
}
