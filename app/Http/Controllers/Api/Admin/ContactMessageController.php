<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of visitor contact messages.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ContactMessage::query()->orderByDesc('created_at');

        if ($request->has('unread')) {
            $query->where('is_read', false);
        }

        $messages = $query->get();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'data' => $messages,
        ]);
    }

    /**
     * Display the specified contact message and mark as read.
     */
    public function show(ContactMessage $message): JsonResponse
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }

    /**
     * Toggle read/unread status of the message.
     */
    public function toggleRead(ContactMessage $message): JsonResponse
    {
        $message->update(['is_read' => !$message->is_read]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesan berhasil diubah!',
            'data' => $message,
        ]);
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(ContactMessage $message): JsonResponse
    {
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus!',
        ]);
    }
}
