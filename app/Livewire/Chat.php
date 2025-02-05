<?php
namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $receiverId; // Properti yang diterima
    public $message = "";
    public bool $isFirstRender = true;
    public bool $isEnded = false;

    public function getChatWithUserName()
    {
        // Ambil nama pengguna lawan chat berdasarkan ID
        $user = User::find($this->receiverId);
        return $user ? $user->name : 'Unknown User';
    }

    public function mount($receiverId)
    {
        if ($receiverId == Auth::id()) {
            return redirect()->route('dashboard');
        }

        // Validasi pengguna dan penerima
        if (Auth::user()->id_role == 3) {
            $receiver = User::find($receiverId);
            if (!$receiver || $receiver->id_role != 2) {
                return redirect()->route('dashboard');
            }
        }elseif (Auth::user()->id_role == 2) {
            $receiver = User::find($receiverId);
            if (!$receiver || $receiver->id_role == 1) {
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->route('dashboard');
        }

        $this->receiverId = $receiverId;
    }

    
    public function render()
    {
        if (!in_array(Auth::user()->id_role, [2, 3])) {
            return redirect()->route('dashboard');
        }
        

        if ($this->isFirstRender) {
            $this->dispatch('scroll-bottom');
            $this->isFirstRender = false; // Set menjadi false setelah pertama kali
        }

        $chatSession = ChatSession::where(function ($query) {
            $query->where('from_user_id', Auth::id())
                ->where('to_user_id', $this->receiverId)
                ->where('is_ended', 0);
        })->orWhere(function ($query) {
            $query->where('from_user_id', $this->receiverId)
                ->where('to_user_id', Auth::id())
                ->where('is_ended', 0);
        })->first();

        if (!$chatSession) {
            $this->isEnded = true;
        }
    
        // Jika sesi tidak ditemukan atau berakhir
        $sessionId = $chatSession ? $chatSession->id : null;
        
        
        return view('livewire.chat', [
            'messages' => !$this->isEnded ? Message::where(function ($query) use ($sessionId) {
                $query->where('from_user_id', Auth::id())
                    ->where('to_user_id', $this->receiverId)
                    ->where('session_id', $sessionId);
            })->orWhere(function ($query) use ($sessionId) {
                $query->where('from_user_id', $this->receiverId)
                    ->where('to_user_id', Auth::id())
                    ->where('session_id', $sessionId);
            })->orderBy('created_at', 'asc')->get() : [],
            Message::where('to_user_id', Auth::id())
            ->where('from_user_id', $this->receiverId)
            ->where('is_read', false)
            ->update(['is_read' => true])
        ]);
    }



    public function sendMessage()
    {
        // Ambil sesi chat saat ini
        $chatSession = ChatSession::where(function ($query) {
            $query->where('from_user_id', Auth::id())
                ->where('to_user_id', $this->receiverId)
                ->where('is_ended', 0);
        })->orWhere(function ($query) {
            $query->where('from_user_id', $this->receiverId)
                ->where('to_user_id', Auth::id())
                ->where('is_ended', 0);
        })->first();

        // Pastikan sesi chat ditemukan
        if (!$chatSession) {
            $chatSession = ChatSession::create([
                'from_user_id' => Auth::id(),
                'to_user_id' => $this->receiverId,
            ]);
        }

        // Simpan pesan baru
        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $this->receiverId,
            'message' => $this->message,
            'session_id' => $chatSession->id, // Tambahkan session_id
        ]);

        $this->reset('message');
        $this->dispatch('scroll-bottom');
    }

    public function endChat()
    {
        // Cari sesi chat berdasarkan pengguna yang login dan penerima
        $chatSession = ChatSession::where(function ($query) {
            $query->where('from_user_id', $this->receiverId) // masyarakat adalah pengirim
                ->where('to_user_id', Auth::id()) // dokter adalah penerima
                ->first();
        });

        // Validasi: Dokter hanya bisa mengakhiri sesi yang ada
        if ($chatSession && Auth::user()->id_role == 2) {
            $chatSession->update(['is_ended' => true]); // Tandai sesi sebagai diakhiri
            
            $this->isEnded = true;

            session()->flash('message', 'Chat has been ended successfully.');
            return redirect()->route('dashboard');
        }
        // Jika tidak valid, beri pesan error
        session()->flash('error', 'Chat session not found or unauthorized action.');
        return redirect()->route('dashboard');
    }

}
