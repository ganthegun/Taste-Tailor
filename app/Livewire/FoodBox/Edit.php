<?php

namespace App\Livewire\FoodBox;

use Livewire\Component;
use App\Models\FoodBox;
use App\Models\Menu;

class Edit extends Component
{
    public int $id;
    public string $name;
    public string $description;
    public string $dietary_preference;
    public float $total_price;
    public int $user_id;
    public array $menus;
    public array $selected_menus;

    public function render()
    {
        return view('livewire.food-box.edit');
    }

    public function mount($id)
    {
        $food_box = FoodBox::find($id);
        $this->id = $food_box->id;
        $this->name = $food_box->name;
        $this->description = $food_box->description;
        $this->dietary_preference = $food_box->dietary_preference;
        $this->total_price = $food_box->total_price;
        $this->user_id = $food_box->user_id;
        $this->menus = Menu::all()->toArray();
        $this->selected_menus = $food_box->menus()->get()->toArray();
    }

    public function addMenu($id)
    {
        $menu = Menu::find($id);
        if ($menu && !collect($this->selected_menus)->contains('id', $menu->id)) {
            $this->selected_menus[] = $menu->toArray();
            $this->total_price += $menu->price;
        }
    }

    public function removeMenu($id)
    {
        $menu = Menu::find($id);
        if ($menu && collect($this->selected_menus)->contains('id', $menu->id)) {
            $this->selected_menus = collect($this->selected_menus)->reject(function ($item) use ($menu) {
                return $item['id'] === $menu->id;
            })->values()->toArray();
            $this->total_price -= $menu->price;
        }
    }

    public function update($id)
    {
        $food_box = FoodBox::find($id);
        $validated = $this->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'dietary_preference' => ['required', 'string'],
            'total_price' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
        $food_box->update($validated);

        $menu_ids = collect($this->selected_menus)->pluck('id')->toArray();
        $food_box->menus()->sync($menu_ids);

        $this->dispatch('food-box-updated');
    }
}
