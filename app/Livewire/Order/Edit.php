<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;

class Edit extends Component
{
    public $order;
    public string $address;

    public function render()
    {
        return view('livewire.order.edit');
    }

    public function mount($id)
    {
        $this->order = auth()->user()->orders()->with('orderFoodBoxes.foodBox')->findOrFail($id);
        $this->address = $this->order->address;
    }

    public function update()
    {
        $this->validate([
            'address' => 'required|string|max:255',
        ]);

        $this->order->update(['address' => $this->address]);

        $this->dispatch('success');
    }

    public function cancel()
    {
        return redirect()->route('order.view');
    }
}
