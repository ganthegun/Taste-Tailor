<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Edit extends Component
{
    use WithFileUploads;
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public string $nutrient;
    public string $image;
    public $upload;

    public function render()
    {
        return view('livewire.menu.edit');
    }

    public function mount($id)
    {
        $menu = Menu::find($id);
        $this->id = $menu->id;
        $this->name = $menu->name;
        $this->description = $menu->description;
        $this->price = $menu->price;
        $this->nutrient = $menu->nutrient;
        $this->image = $menu->image;
    }

    public function update($id)
    {
        $menu = Menu::find($id);
        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'nutrient' => 'required|string',
        ];
        if ($this->upload instanceof TemporaryUploadedFile) 
        {
            $rules['upload'] = 'image|max:5120';
        }
        $validated = $this->validate($rules);
        if ($this->upload instanceof TemporaryUploadedFile) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $this->upload->store('menu', 'public');
        }
        $menu->update($validated);
        $this->dispatch('menu-updated');
    }
}
