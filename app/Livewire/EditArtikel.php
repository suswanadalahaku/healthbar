<?php

namespace App\Livewire;

use App\Models\Articles;
use App\Models\ValidateArticles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditArtikel extends Component
{
    use WithFileUploads;

    public $articleId;
    public $title;
    public $content;
    public $image;

    public $existingImage;
    public $hasImage = false;
    protected $listeners = ['confirmSave' => 'updateContent'];

    public function mount($id)
    {
        $article = Articles::findOrFail($id);
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->content = $article->content;
        $this->existingImage = $article->image;
    }

    public function updatedImage()
    {
        $this->hasImage = true;
    }

    public function updateContent(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Cari artikel berdasarkan ID, atau gagal jika tidak ditemukan
        $article = Articles::findOrFail($id);

        // Jika ada file gambar baru, konversi ke base64
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Convert image to base64
            $article->image = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($image));
        }

        // Update judul dan konten artikel
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->is_approved = 0; // Reset status ke pending
        $article->save();

        // Perbarui atau buat entri baru di tabel validate_articles
        ValidateArticles::updateOrCreate(
            ['id_artikel' => $article->id],
            [
                'message' => 'Perubahan telah dikirim, menunggu validasi dokter.',
                'status' => 'pending',
            ]
        );

        session()->flash('message', 'Artikel berhasil diperbarui.');
        return redirect()->route('dashboard');
    }


    public function render()
    {
        $articles = Articles::where('is_approved', true)->get();

        return view('livewire.edit-artikel', compact('articles'));
    }
}
