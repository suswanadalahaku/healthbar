<?php

namespace App\Livewire;

use App\Models\Articles;
use Livewire\Component;

class TinjauArtikel extends Component
{
    public function render()
    {
        // $articles = Articles::where('is_approved', false)->get();
        $articles = Articles::where('is_approved', false)
        ->where(function ($query) {
            $query->whereHas('validateArticles', function ($subQuery) {
                $subQuery->where('status', '!=', 'rejected');
            })
            ->orWhereDoesntHave('validateArticles');
        })
        ->get();

        return view('livewire.tinjau-artikel',compact('articles'));
    }
}
