<?php

namespace App\Livewire;

use App\Models\Wedding;
use Livewire\Component;

/**
 * EditableField - Component để sửa trực tiếp field của model Wedding
 * Khác với EditableText (sửa content JSON), component này sửa thẳng column
 */
class EditableField extends Component
{
    public int $weddingId;
    public string $field;       // Column name: groom_name, bride_name, etc.
    public string $tag = 'span';
    public string $class = '';
    
    public string $value = '';
    public bool $editing = false;

    public function mount()
    {
        $wedding = Wedding::find($this->weddingId);
        $this->value = $wedding?->{$this->field} ?? '';
    }

    public function startEditing()
    {
        $this->editing = true;
    }

    public function save()
    {
        $wedding = Wedding::find($this->weddingId);
        
        if ($wedding) {
            $wedding->{$this->field} = $this->value;
            $wedding->save();
        }
        
        $this->editing = false;
        $this->dispatch('field-saved', field: $this->field, value: $this->value);
    }

    public function cancel()
    {
        $wedding = Wedding::find($this->weddingId);
        $this->value = $wedding?->{$this->field} ?? '';
        $this->editing = false;
    }

    public function render()
    {
        return view('livewire.editable-field');
    }
}
