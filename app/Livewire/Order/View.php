<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\OrderFoodBox;

use App\Models\Order;


use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Subscription;

class View extends Component
{
    public $orders;

    public function render()
    {
        return view('livewire.order.view');
    }

    public function mount()
    {
        $this->orders = auth()->user()->orders()->with('foodBoxes')->get();
    }

    public function delete($order_id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $order = auth()->user()->orders()->with('products.prices.subscriptions')->find($order_id);

        if ($order) {
            foreach ($order->products as $product) {
                // Delete associated prices
                foreach ($product->prices as $price) {
                    // Cancel the subscription if it exists
                    foreach ($price->subscriptions as $subscription) {
                        Subscription::retrieve($subscription->stripe_subscription_id)->cancel();
                    }
                    // Delete the price
                    Price::update($price->stripe_price_id, ['active' => false]);
                }
                // Delete the product
                Product::update($product->stripe_product_id, ['active' => false]);
            }

            $order->delete();
            $this->orders = auth()->user()->orders()->with('foodBoxes')->get(); // Refresh the orders list
            $this->dispatch('success');
        } else {
            $this->dispatch('error');
        }
    }

    public function edit($order_id)
    {
        return redirect()->route('order.edit', ['id' => $order_id]);
    }
}
