<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Articles;

class TampilArtikel extends Component
{
    public function render()
    {
        $articles = Articles::where('is_approved', true)->get();

        // Proses konten untuk merender media
        foreach ($articles as $article) {
            $article->content = $this->renderMedia($article->content);
        }

        return view('livewire.tampil-artikel', compact('articles'));
    }

    private function renderMedia($content)
    {
        return preg_replace_callback(
            '/<oembed\s+url=["\']([^"\']+)["\']><\/oembed>/i',
            function ($matches) {
                $url = $matches[1];
                // Pastikan URL adalah YouTube atau platform yang mendukung embed
                if (strpos($url, 'youtube.com/watch') !== false) {
                    // Ubah URL menjadi format embed YouTube
                    $videoId = preg_replace('/.*v=([^&]+).*/', '$1', $url);
                    return '<iframe class="max-h-fit max-w-fit " src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
                }
                // Tambahkan logika untuk platform lain di sini
                return '<a href="' . htmlspecialchars($url) . '" target="_blank">' . htmlspecialchars($url) . '</a>';
            },
            $content
        );
    }
}
