<?php

namespace App\Livewire\Wedding;

use App\Models\Wedding;
use App\Models\Template;
use App\Services\WeddingService;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class EditWedding extends Component
{
    use WithFileUploads;

    public Wedding $wedding;
    public $activeTab = 'basic';
    
    // Basic Info
    public $groom_name;
    public $bride_name;
    public $event_date;
    public $template_id;
    public $status; // String value for Livewire binding
    
    // Groom Family
    public $groom_father;
    public $groom_mother;
    public $groom_ceremony_time;
    public $groom_ceremony_date;
    public $groom_address;
    public $groom_map_url;
    public $groom_reception_time;
    public $groom_reception_venue;
    public $groom_reception_address;
    public $groom_qr_info;
    
    // Bride Family
    public $bride_father;
    public $bride_mother;
    public $bride_ceremony_time;
    public $bride_ceremony_date;
    public $bride_address;
    public $bride_map_url;
    public $bride_reception_time;
    public $bride_reception_venue;
    public $bride_reception_address;
    public $bride_qr_info;
    
    // Settings
    public $slug;
    public $password;
    public $is_auto_approve_wishes = false;
    public $show_preload = false;
    public $falling_effect = 'hearts'; // String value for Livewire binding
    
    // Media Uploads (temporary)
    public $cover;
    public $hero;
    public $groom_photo;
    public $bride_photo;
    public $groom_qr;
    public $bride_qr;
    public $gallery = [];
    public $background_music;

    protected function rules()
    {
        return [
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'status' => 'nullable|string',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'groom_address' => 'nullable|string|max:1000',
            'bride_address' => 'nullable|string|max:1000',
            'groom_map_url' => 'nullable|url|max:500',
            'bride_map_url' => 'nullable|url|max:500',
            'groom_reception_venue' => 'nullable|string|max:255',
            'bride_reception_venue' => 'nullable|string|max:255',
            'groom_reception_address' => 'nullable|string|max:1000',
            'bride_reception_address' => 'nullable|string|max:1000',
            'groom_qr_info' => 'nullable|string|max:1000',
            'bride_qr_info' => 'nullable|string|max:1000',
            'slug' => 'nullable|string|max:255|unique:weddings,slug,' . $this->wedding->id,
            'password' => 'nullable|string|max:255',
            'falling_effect' => 'nullable|string',
            'cover' => 'nullable|image|max:5120',
            'hero' => 'nullable|image|max:5120',
            'groom_photo' => 'nullable|image|max:5120',
            'bride_photo' => 'nullable|image|max:5120',
            'groom_qr' => 'nullable|image|max:2048',
            'bride_qr' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:5120',
            'background_music' => 'nullable|file|mimes:mp3|max:10240',
        ];
    }

    public function mount(Wedding $wedding)
    {
        // Check ownership using WeddingService
        if (!WeddingService::canAccess(Auth::user(), $wedding)) {
            abort(403);
        }

        $this->wedding = $wedding;
        
        // Fill form fields - convert Enum to string for Livewire binding
        $this->groom_name = $wedding->groom_name;
        $this->bride_name = $wedding->bride_name;
        $this->event_date = $wedding->event_date?->format('Y-m-d');
        $this->template_id = $wedding->template_id;
        
        // Convert Enum to string value
        $this->status = $wedding->status instanceof WeddingStatus 
            ? $wedding->status->value 
            : ($wedding->status ?? WeddingStatus::DRAFT->value);
        
        $this->groom_father = $wedding->groom_father;
        $this->groom_mother = $wedding->groom_mother;
        $this->groom_ceremony_time = $wedding->groom_ceremony_time?->format('H:i');
        $this->groom_ceremony_date = $wedding->groom_ceremony_date?->format('Y-m-d');
        $this->groom_address = $wedding->groom_address;
        $this->groom_map_url = $wedding->groom_map_url;
        $this->groom_reception_time = $wedding->groom_reception_time?->format('H:i');
        $this->groom_reception_venue = $wedding->groom_reception_venue;
        $this->groom_reception_address = $wedding->groom_reception_address;
        $this->groom_qr_info = $wedding->groom_qr_info;
        
        $this->bride_father = $wedding->bride_father;
        $this->bride_mother = $wedding->bride_mother;
        $this->bride_ceremony_time = $wedding->bride_ceremony_time?->format('H:i');
        $this->bride_ceremony_date = $wedding->bride_ceremony_date?->format('Y-m-d');
        $this->bride_address = $wedding->bride_address;
        $this->bride_map_url = $wedding->bride_map_url;
        $this->bride_reception_time = $wedding->bride_reception_time?->format('H:i');
        $this->bride_reception_venue = $wedding->bride_reception_venue;
        $this->bride_reception_address = $wedding->bride_reception_address;
        $this->bride_qr_info = $wedding->bride_qr_info;
        
        $this->slug = $wedding->slug;
        $this->password = $wedding->password;
        $this->is_auto_approve_wishes = $wedding->is_auto_approve_wishes;
        $this->show_preload = $wedding->show_preload;
        
        // Convert Enum to string value
        $this->falling_effect = $wedding->falling_effect instanceof FallingEffect 
            ? $wedding->falling_effect->value 
            : ($wedding->falling_effect ?? FallingEffect::HEARTS->value);
    }

    public function save()
    {
        $this->validate();
        
        // Use WeddingService for centralized update logic
        WeddingService::updateWedding($this->wedding, [
            'groom_name' => $this->groom_name,
            'bride_name' => $this->bride_name,
            'event_date' => $this->event_date,
            'template_id' => $this->template_id,
            'status' => $this->status,
            'groom_father' => $this->groom_father,
            'groom_mother' => $this->groom_mother,
            'groom_ceremony_time' => $this->groom_ceremony_time,
            'groom_ceremony_date' => $this->groom_ceremony_date,
            'groom_address' => $this->groom_address,
            'groom_map_url' => $this->groom_map_url,
            'groom_reception_time' => $this->groom_reception_time,
            'groom_reception_venue' => $this->groom_reception_venue,
            'groom_reception_address' => $this->groom_reception_address,
            'groom_qr_info' => $this->groom_qr_info,
            'bride_father' => $this->bride_father,
            'bride_mother' => $this->bride_mother,
            'bride_ceremony_time' => $this->bride_ceremony_time,
            'bride_ceremony_date' => $this->bride_ceremony_date,
            'bride_address' => $this->bride_address,
            'bride_map_url' => $this->bride_map_url,
            'bride_reception_time' => $this->bride_reception_time,
            'bride_reception_venue' => $this->bride_reception_venue,
            'bride_reception_address' => $this->bride_reception_address,
            'bride_qr_info' => $this->bride_qr_info,
            'slug' => $this->slug,
            'password' => $this->password,
            'is_auto_approve_wishes' => $this->is_auto_approve_wishes,
            'show_preload' => $this->show_preload,
            'falling_effect' => $this->falling_effect,
        ]);
        
        // Handle media uploads (keep media handling in Livewire)
        $this->handleMediaUploads();
        
        session()->flash('success', 'Thiệp cưới đã được cập nhật!');
    }
    
    protected function handleMediaUploads()
    {
        $mediaCollections = [
            'cover' => $this->cover,
            'hero' => $this->hero,
            'groom_photo' => $this->groom_photo,
            'bride_photo' => $this->bride_photo,
            'groom_qr' => $this->groom_qr,
            'bride_qr' => $this->bride_qr,
        ];
        
        foreach ($mediaCollections as $collection => $file) {
            if ($file) {
                $this->wedding->clearMediaCollection($collection);
                $this->wedding->addMedia($file->getRealPath())
                    ->usingFileName($file->getClientOriginalName())
                    ->toMediaCollection($collection);
            }
        }
        
        // Handle gallery (multiple)
        if (!empty($this->gallery)) {
            foreach ($this->gallery as $file) {
                $this->wedding->addMedia($file->getRealPath())
                    ->usingFileName($file->getClientOriginalName())
                    ->toMediaCollection('gallery');
            }
            $this->gallery = [];
        }
        
        // Handle music
        if ($this->background_music) {
            $path = $this->background_music->store('music', 'public');
            $this->wedding->update(['background_music' => $path]);
            $this->background_music = null;
        }
        
        // Reset temp files
        $this->cover = null;
        $this->hero = null;
        $this->groom_photo = null;
        $this->bride_photo = null;
        $this->groom_qr = null;
        $this->bride_qr = null;
    }
    
    public function deleteMedia($collection, $mediaId = null)
    {
        if ($mediaId) {
            $this->wedding->media()->where('id', $mediaId)->delete();
        } else {
            $this->wedding->clearMediaCollection($collection);
        }
    }

    public function isPro(): bool
    {
        $tier = $this->wedding->tier;
        
        if ($tier instanceof WeddingTier) {
            return $tier === WeddingTier::PRO;
        }
        
        return $tier === 'pro' || $tier === WeddingTier::PRO->value;
    }

    public function render()
    {
        $templates = Template::where('type', 'wedding')
            ->where('is_active', true)
            ->get();
            
        return view('livewire.wedding.edit-wedding', [
            'templates' => $templates,
        ])->layout('layouts.dashboard', [
            'header' => 'Chỉnh sửa thiệp: ' . $this->groom_name . ' & ' . $this->bride_name,
        ]);
    }
}
