<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Articles;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TambahArtikel extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $image;

    public $hasImage = false;

    protected $listeners = ['confirmSave' => 'saveContent'];

    public function updatedImage()
    {
        $this->hasImage = true; // Set ke true jika gambar diunggah
    }

    public function render()
    {
        if (Auth::user()->id_role != 1) {
            return redirect()->route('dashboard');
        }

        return view('livewire.tambah-artikel');
    }

    public function saveContent()
    {
        // Validasi input
        $this->validate([
            'title' => 'required|string|max:255', // Validasi untuk title
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Maksimum 2MB
        ]);

        $imagePath = null;

        // Proses dan simpan gambar jika ada
        if ($this->image) {
            $imagePath = $this->image->store('images', 'public');
        }

        // Simpan ke tabel Articles
        Articles::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $imagePath, // Simpan path gambar
        ]);

        // Flash message untuk notifikasi
        session()->flash('message', 'Content saved successfully.');

        // Reset form
        $this->reset(['title', 'content', 'image']);

        // Emit event ke frontend untuk mereset editor
        $this->dispatch('reset-editor');
    }
}
