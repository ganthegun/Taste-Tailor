<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\FoodBox;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public array $food_boxes;
    public array $menus;
    public array $selected_food_boxes;
    public string $address;
    public float $price;
    public int $meals_per_week;
    public array $quantity;

    public function render()
    {
        return view('livewire.order.create');
    }

    public function mount()
    {
        $this->food_boxes = FoodBox::all()->toArray();
        $this->menus = FoodBox::with('menus')->get()->map(function ($food_box) {
            return $food_box->menus; 
        })->toArray();
        $this->price = 0.00;
        $this->meals_per_week = 1; // Default value, can be changed by user
    }

    public function addFoodBox($id)
    {
        $food_box = FoodBox::find($id);
        if ($food_box && !collect($this->selected_food_boxes)->contains('id', $food_box->id)) {
            $this->selected_food_boxes[] = $food_box->toArray();
        }
        $this->recalculatePrice();
    }

    public function removeFoodBox($id)
    {
        $food_box = FoodBox::find($id);
        if ($food_box && collect($this->selected_food_boxes)->contains('id', $food_box->id)) {
            $this->selected_food_boxes = collect($this->selected_food_boxes)->reject(function ($item) use ($food_box) {
                return $item['id'] === $food_box->id;
            })->values()->toArray();
        }
        $this->recalculatePrice();
    }

    public function updatePrice()
    {
        $this->recalculatePrice();
    }

    private function recalculatePrice()
    {
        $this->price = 0;
    
        foreach ($this->selected_food_boxes as $food_box) {
            $quantity = $this->quantity[$food_box['id']] ?? 1; // Default to 1 if quantity not set
            $this->price += $food_box['total_price'] * $quantity;
        }
        
        $this->price *= $this->meals_per_week;
    }

    public function pay()
    {
        if (empty($this->selected_food_boxes)) {
            session()->flash('error', 'Please select at least one food box.');
            return;
        }

        $validated = $this->validate([
            'address' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'meals_per_week' => ['required', 'integer', 'min:1'],
            'quantity' => ['array'],
        ]);

        session([
            'order_data' => [
                "selected_food_boxes" => $this->selected_food_boxes,
                "address" =>  $validated['address'],
                "price" => $validated['price'],
                "meals_per_week" => $validated['meals_per_week'],
                "quantity" => $this->quantity,
            ]
        ]);

        return redirect()->route('payment.index');
    }
}
