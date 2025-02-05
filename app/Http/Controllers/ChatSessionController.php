<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
{
    public function startChat($receiverId)
    {
        $user = Auth::user();

        $chatSession = ChatSession::where(function ($query) use ($user, $receiverId) {
            $query->where('from_user_id', $user->id)
                ->where('to_user_id', $receiverId)
                ->where('is_ended', 0);
        })->orWhere(function ($query) use ($user, $receiverId) {
            $query->where('from_user_id', $receiverId)
                ->where('to_user_id', $user->id)
                ->where('is_ended', 0);
        })->first();

        // Jika sesi sudah ada tetapi telah diakhiri, buat sesi baru
        if ($chatSession && $chatSession->is_ended) {
            $chatSession = ChatSession::create([
                'from_user_id' => $user->id,
                'to_user_id' => $receiverId,
            ]);
        } elseif (!$chatSession) {
            $chatSession = ChatSession::create([
                'from_user_id' => $user->id,
                'to_user_id' => $receiverId,
            ]);
        }

        return redirect()->route('chat', ['session_id' => $chatSession->id, 'receiverId' => $receiverId]);
    }

}