<?php

namespace App\Livewire\FoodBox;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Menu;
use App\Models\FoodBox;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    public string $name;
    public string $description;
    public $dietary_preference;
    public float $total_price = 0.00;
    public int $user_id;
    public $menus = [];
    public $selectedMenus = [];

    public function render()
    {
        return view('livewire.food-box.create');
    }

    public function mount()
    {
        $this->menus = Menu::all();
    }

    public function addMenu($id)
    {
        $menu = Menu::find($id);
        if ($menu && !collect($this->selectedMenus)->contains('id', $menu->id)) {
            $this->selectedMenus[] = $menu->toArray();
            $this->total_price += $menu->price;
        }
    }

    public function removeMenu($id)
    {
        $menu = Menu::find($id);
        if ($menu && collect($this->selectedMenus)->contains('id', $menu->id)) {
            $this->selectedMenus = collect($this->selectedMenus)->reject(function ($item) use ($menu) {
                return $item['id'] === $menu->id;
            })->values()->toArray();
            $this->total_price -= $menu->price;
        }
    }

    public function create()
    {
        $this->user_id = Auth::user()->id;

        if (empty($this->selectedMenus)) {
            session()->flash('error', 'Please select at least one menu.');
            return;
        }

        if (!$this->dietary_preference) {
            session()->flash('error', 'Please select a dietary preference.');
            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'dietary_preference' => ['required', 'string'],
            'total_price' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
        FoodBox::create($validated);

        $foodBox = FoodBox::latest()->first();
        $menu_ids = collect($this->selectedMenus)->pluck('id')->toArray();
        $foodBox->menus()->attach($menu_ids);

        $this->dispatch('food-box-created');
    }
}
