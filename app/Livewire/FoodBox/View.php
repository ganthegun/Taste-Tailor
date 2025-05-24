<?php

namespace App\Livewire\FoodBox;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodBox;

class View extends Component
{
    public array $food_boxes;
    public array $menus;

    public function render()
    {
        $user = Auth::user();
        $this->food_boxes = $user->foodBoxes()->get()->toArray();
        $this->menus = $user->foodBoxes()->with('menus')->get()->map(function ($foodBox) {
            return $foodBox->menus; 
        })->toArray();
        return view('livewire.food-box.view');
    }

    public function delete($id)
    {
        $food_box = FoodBox::find($id);
        $food_box->delete();
        $this->dispatch('food-box-deleted');
    }

    public function edit($id)
    {
        return redirect()->route('food-box.edit', ['id' => $id]);
    }
}
