<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Articles;
use Livewire\WithFileUploads;
use App\Models\ValidateArticles;
use Illuminate\Support\Facades\Storage;

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

    public function updateContent()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $article = Articles::findOrFail($this->articleId);

        if ($this->image) {
            if ($article->image) {
                Storage::delete($article->image);
            }
            $article->image = $this->image->store('images', 'public');
        }

        $article->title = $this->title;
        $article->content = $this->content;
        $article->is_approved = 0; // Reset status ke pending
        $article->save();

        // Perbarui atau buat entri baru di tabel validate_articles
        ValidateArticles::updateOrCreate(
            ['id_artikel' => $article->id],
            [
                'message' => 'Perubahan telah dikirim, menunggu validasi dokter.', // Pesan default
                'status' => 'pending', // Status default setelah update
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
