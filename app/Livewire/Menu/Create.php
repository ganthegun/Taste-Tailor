<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Menu;

class Create extends Component
{
    use WithFileUploads;
    public string $name;
    public string $description;
    public float $price;
    public string $nutrient;
    public $image;

    public function render()
    {
        return view('livewire.menu.create');
    }

    public function submit() 
    {
        $validated = $this->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'nutrient' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'image' => ['required', 'image', 'max:5120'],
        ]); 

        $path = $this->image->store('menu', 'public');
        $validated['image'] = $path;

        Menu::create($validated);

        $this->dispatch('menu-created');
    }
}
