<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class ChatHistory extends Component
{
    public $sessions;
    public $selectedDate = null;

    public function mount()
    {
        if (Auth::user()->id_role != 3) {
            return redirect()->route('dashboard');
        }

        // Mengambil semua sesi chat yang sudah berakhir
        $this->sessions = ChatSession::with(['fromUser', 'toUser', 'messages'])
            ->where(function ($query) {
                $query->where('from_user_id', Auth::id())
                    ->orWhere('to_user_id', Auth::id());
            })
            ->where('is_ended', 1)
            ->get();
    }

    public function selectDate($date)
    {
        // Toggle antara memilih dan membatalkan pemilihan tanggal
        if ($this->selectedDate === $date) {
            $this->selectedDate = null; // Jika tanggal yang sama diklik, sembunyikan pesan
        } else {
            $this->selectedDate = $date; // Pilih tanggal baru untuk menampilkan pesan
        }
    }

    public function render()
    {
        return view('livewire.chat-history', [
            'sessions' => $this->sessions,
            'selectedDate' => $this->selectedDate
        ]);
    }
}

