<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\ValidateArticles;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // public function index()
    // {
    //     $articles = Articles::where('is_approved', true)->get();

    //     // Proses konten untuk merender media
    //     foreach ($articles as $article) {
    //         $article->content = $this->renderMedia($article->content);
    //     }

    //     return view('livewire.pages.tampil-artikel', compact('articles'));
    // }

    public function show($id)
    {
        $article = Articles::findOrFail($id);

        // Render konten media untuk artikel
        $article->content = $this->renderMedia($article->content);

        return view('detail-artikel', compact('article'));
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

    public function approve($id)
    {
        $article = Articles::findOrFail($id);
        $article->is_approved = 1; // Set is_approved menjadi true
        $article->save();

        ValidateArticles::where('id_artikel', $id)->delete();

        return redirect()->route('tampil-artikel')->with('success', 'Artikel berhasil diapprove.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $article = Articles::findOrFail($id);

        ValidateArticles::updateOrCreate(
            ['id_artikel' => $article->id],
            [
                'message' => $request->message,
                'status' => 'rejected',
            ]
        );

        $article->is_approved = 0;
        $article->save();

        return redirect()->route('tinjau-artikel')->with('success', 'Artikel berhasil direject dengan pesan.');
    }


    public function destroy($id)
    {
        try {
            // Cari artikel berdasarkan ID
            $article = Articles::findOrFail($id);

            // Hapus artikel
            $article->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat menghapus artikel.');
        }
    }




}
