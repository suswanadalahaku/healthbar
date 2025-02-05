<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Articles;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TambahArtikel extends Component
{
    use WithFileUploads;

    public $title, $content, $image;
    public $hasImage = false;

    public function updatedImage()
    {
        $this->hasImage = true; // Set ke true jika gambar diunggah
    }

    public function clearImage()
    {
        $this->image = null;
        $this->hasImage = false;
    }

    public function render()
    {
        if (Auth::user()->id_role != 1) {
            return redirect()->route('dashboard');
        }

        return view('livewire.tambah-artikel');
    }

    public function saveContent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Judul wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'content.required' => 'Content wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2 MB',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Articles::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('message', 'Content saved successfully.');
    }
}
