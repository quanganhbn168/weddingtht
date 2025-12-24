<?php

namespace App\Livewire;

use App\Models\Wedding;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditableImage extends Component
{
    use WithFileUploads;

    public int $weddingId;
    public string $collectionName = 'cover';
    public string $aspectRatio = '16/9';
    public string $placeholderUrl = '';
    public $photo;

    public function mount()
    {
        // Set default placeholder based on collection
        if (empty($this->placeholderUrl)) {
            $this->placeholderUrl = match($this->collectionName) {
                'cover' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80',
                'groom_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                'bride_photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop',
                default => 'https://via.placeholder.com/400x400?text=No+Image',
            };
        }
    }

    /**
     * When photo is updated, save it to media collection
     */
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:10240', // 10MB max
        ]);

        $wedding = Wedding::find($this->weddingId);
        
        if (!$wedding) {
            return;
        }

        // Clear existing media in this collection (for single file)
        $wedding->clearMediaCollection($this->collectionName);
        
        // Add new media from the temporary file
        $wedding->addMedia($this->photo->getRealPath())
            ->usingFileName($this->photo->getClientOriginalName())
            ->toMediaCollection($this->collectionName);

        // Dispatch event to refresh UI
        $this->dispatch('image-updated', collection: $this->collectionName);
        
        // Reset photo input
        $this->reset('photo');
    }

    public function render()
    {
        $wedding = Wedding::find($this->weddingId);
        $imageUrl = $wedding?->getFirstMediaUrl($this->collectionName);
        
        // Use placeholder if no image
        if (empty($imageUrl)) {
            $imageUrl = $this->placeholderUrl;
        }
        
        return view('livewire.editable-image', [
            'imageUrl' => $imageUrl,
        ]);
    }
}
