import './bootstrap';

// Alpine is provided by Livewire 3, but for public pages without Livewire, we need to initialize it manually
// or ensure Livewire scripts are present. Since we want these pages to be lightweight:
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
