<?php

namespace App\Livewire;

use App\Models\Wedding;
use Livewire\Component;

class EditableText extends Component
{
    public int $weddingId;
    public string $field; // The content key to edit (e.g., 'groom_father_name')
    public string $defaultText = '';
    public string $tag = 'p'; // HTML tag: p, h1, h2, span, etc.
    public string $class = '';
    
    public string $text = '';
    public bool $editing = false;

    public function mount()
    {
        $wedding = Wedding::find($this->weddingId);
        $this->text = $wedding?->getContentValue($this->field, $this->defaultText) ?? $this->defaultText;
    }

    public function startEditing()
    {
        $this->editing = true;
    }

    public function save()
    {
        $wedding = Wedding::find($this->weddingId);
        
        if ($wedding) {
            $wedding->setContentValue($this->field, $this->text);
            $wedding->save();
        }
        
        $this->editing = false;
        $this->dispatch('text-saved', field: $this->field);
    }

    public function cancel()
    {
        $wedding = Wedding::find($this->weddingId);
        $this->text = $wedding?->getContentValue($this->field, $this->defaultText) ?? $this->defaultText;
        $this->editing = false;
    }

    public function render()
    {
        return view('livewire.editable-text');
    }
}
