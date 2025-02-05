<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class DashboardDokter extends Component
{
    public function render()
    {
        // Ambil hanya pasien yang masih memiliki sesi chat aktif
        $users = User::where('id', '!=', Auth::id()) // Exclude logged-in user
            ->where('id_role', '=', 3) // Hanya pasien (role 3)
            ->whereHas('sentSessions', function ($query) {
                $query->where('is_ended', false) // Hanya sesi yang belum berakhir
                      ->where('to_user_id', Auth::id()); // Dokter hanya melihat pasien yang chat dengannya
            })
            ->with(['unreadMessages']) // Ambil pesan yang belum dibaca
            ->get();

        return view('livewire.dashboard-dokter', compact('users'));
    }
}

