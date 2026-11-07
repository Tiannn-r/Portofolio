<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Get profile data for admin CMS.
     */
    public function show(): JsonResponse
    {
        $profile = Profile::first();

        return response()->json([
            'success' => true,
            'data' => $profile,
        ]);
    }

    /**
     * Update profile and handle avatar / CV PDF uploads.
     */
    public function update(Request $request): JsonResponse
    {
        $profile = Profile::firstOrCreate([], [
            'name' => 'Your Name',
            'roles' => ['Full-Stack Developer'],
            'short_bio' => 'Short bio here',
            'about_me' => 'About me description here',
            'is_available' => true,
        ]);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'roles' => 'sometimes|nullable', // array or JSON string
            'short_bio' => 'sometimes|required|string|max:500',
            'about_me' => 'sometimes|required|string',
            'avatar' => 'sometimes|nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'cv_file' => 'sometimes|nullable|file|mimes:pdf|max:5120',
            'is_available' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|email|max:150',
            'phone' => 'sometimes|nullable|string|max:50',
            'location' => 'sometimes|nullable|string|max:150',
            'social_links' => 'sometimes|nullable',
            'happy_clients' => 'sometimes|nullable|integer|min:0',
            'projects_completed' => 'sometimes|nullable|integer|min:0',
            'years_experience' => 'sometimes|nullable|integer|min:0',
            'awards_received' => 'sometimes|nullable|integer|min:0',
        ]);

        // Handle JSON array fields if sent as JSON string in multipart/form-data
        if ($request->has('roles')) {
            $roles = $request->input('roles');
            $profile->roles = is_string($roles) ? json_decode($roles, true) : $roles;
        }

        if ($request->has('social_links')) {
            $social = $request->input('social_links');
            $profile->social_links = is_string($social) ? json_decode($social, true) : $social;
        }

        if ($request->has('is_available')) {
            $profile->is_available = filter_var($request->input('is_available'), FILTER_VALIDATE_BOOLEAN);
        }

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
        }

        // Handle CV PDF Upload
        if ($request->hasFile('cv_file')) {
            if ($profile->cv_file && Storage::disk('public')->exists($profile->cv_file)) {
                Storage::disk('public')->delete($profile->cv_file);
            }
            $cvPath = $request->file('cv_file')->store('cv', 'public');
            $profile->cv_file = $cvPath;
        }

        // Standard attributes
        $fillable = [
            'name', 'short_bio', 'about_me', 'email', 'phone', 'location',
            'happy_clients', 'projects_completed', 'years_experience', 'awards_received'
        ];

        foreach ($fillable as $field) {
            if ($request->has($field)) {
                $profile->{$field} = $request->input($field);
            }
        }

        $profile->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'data' => $profile->fresh(),
        ]);
    }
}
