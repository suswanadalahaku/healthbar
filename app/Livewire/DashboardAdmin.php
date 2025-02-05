<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Articles;
use App\Models\ValidateArticles;
use Illuminate\Support\Facades\Auth;

class DashboardAdmin extends Component
{
    public $users;

    public function mount()
    {
        // Ambil data user kecuali pengguna yang sedang login
        $this->users = User::where('id', '!=', Auth::id())->get();
    }

    public function showRejectedArticles()
    {
        $rejectedArticles = Articles::join('validate_articles', 'articles.id', '=', 'validate_articles.id_artikel')
            ->select('articles.*', 'validate_articles.message', 'validate_articles.created_at as rejected_at')
            ->get();

        return view('dashboard.rejected-articles', compact('rejectedArticles'));
    }


    public function render()
    {
        $articles = Articles::where('is_approved', true)->get();

        $rejectedArticles = ValidateArticles::with('article')
        ->get();

        // Proses konten untuk merender media
        // foreach ($articles as $article) {
        //     $article->content = $this->renderMedia($article->content);
        // }

        return view('livewire.dashboard-admin', [
            'users' => $this->users, // Pastikan data dikirim ke view
        ], compact('articles', 'rejectedArticles'));
    }
}
