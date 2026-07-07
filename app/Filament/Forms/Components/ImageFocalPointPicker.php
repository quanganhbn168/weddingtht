<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class ImageFocalPointPicker extends Field
{
    protected string $view = 'filament.forms.components.image-focal-point-picker';

    protected string|Closure|null $imageUrl = null;

    public function imageUrl(string|Closure|null $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->evaluate($this->imageUrl);
    }
}
