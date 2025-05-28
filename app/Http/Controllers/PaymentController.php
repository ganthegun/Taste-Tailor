<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderFoodBox;
use App\Models\Product;
use App\Models\Price;
use App\Models\Subscription;
use Faker\Provider\ar_EG\Payment;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;
use Stripe\Subscription as StripeSubscription;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {   
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentMethods = $request->user()->customer ? 
            PaymentMethod::all(['customer' => $request->user()->customer->stripe_customer_id]) : 
            []; 
        
        $order_data = session('order_data');

        return view('payment.index', [
            'selected_food_boxes' => $order_data['selected_food_boxes'],
            'address' =>  $order_data['address'],
            'price' => $order_data['price'],
            'meals_per_week' => $order_data['meals_per_week'],
            'quantity' => $order_data['quantity'],
            'publishableKey' => config('services.stripe.public'),
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function delete(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentMethod = PaymentMethod::retrieve($request->payment_method_id);
        $paymentMethod->detach();
        return redirect()->back()->with('success', 'Payment method deleted successfully.');
        
    }

    public function pay(Request $request)
    {
        $order_data = session('order_data');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a new customer if not already created
        $customer = $request->user()->customer;

        if (!$customer) {
            $stripeCustomer = Customer::create([
                'email' => $request->user()->email,
                'name' => $request->user()->name,
            ]);
            $customer = $request->user()->customer()->create([
                'stripe_customer_id' => $stripeCustomer->id
            ]);
        }

        $customer_id = $customer->id;
        $stripe_customer_id = $customer->stripe_customer_id;

        // Attach the payment method to the customer if not already attached
        $stripePaymentMethod = PaymentMethod::retrieve($request->payment_method_id);
        if (!$stripePaymentMethod->customer) {
            $stripePaymentMethod->attach(['customer' => $stripe_customer_id]);
        }

        // Create a new product
        $number = Order::where('user_id', $request->user()->id)->count() + 1;
        $stripeProduct = StripeProduct::create([
            'name' => $request->user()->name . '\'s Food Box ' . $number,
        ]);
        $product = Product::create([
            'stripe_product_id' => $stripeProduct->id,
            'name' => $request->user()->name . '\'s Food Box ' . $number,
        ]);


        $product_id = $product->id;
        $stripe_product_id = $product->stripe_product_id;

        // Create a new price if not already created
        $price = Price::where('product_id', $product_id)->first();
        if (!$price) {
            // Use `findOrFail` for better error handling
            $stripePrice = StripePrice::create([
                'currency' => 'myr',
                'unit_amount' => $order_data['price'] * 100, // Convert to cents
                'recurring' => ['interval' => 'month'],
                'product' => $stripe_product_id,
            ]);
            $price = Price::create([
                'stripe_price_id' => $stripePrice->id,
                'product_id' => $product_id,
                'unit_amount' => $order_data['price'],
                'currency' => 'myr',
                'recurring_interval' => 'month',
            ]);
        }

        $price_id = $price->id;
        $stripe_price_id = $price->stripe_price_id;

        // Create a Subscription if not already created
        $subscription = Subscription::where('customer_id', $customer_id)
            ->where('price_id', $price_id)
            ->first();

        if (!$subscription) {
            $stripeSubscription = StripeSubscription::create([
                'customer' => $stripe_customer_id,
                'items' => [['price' => $stripe_price_id]],
                'default_payment_method' => $stripePaymentMethod->id,
            ]);
            $subscription = Subscription::create([
                'stripe_subscription_id' => $stripeSubscription->id,
                'customer_id' => $customer_id,
                'price_id' => $price_id,
            ]);
        }

        // Create an Order
        $order = auth()->user()->orders()->create([
            'address' => $order_data['address'],
            'price' => $order_data['price'],
            'meals_per_week' => $order_data['meals_per_week'],
        ]);

        // Create OrderFoodBox entries
        $pairs = collect($order_data['selected_food_boxes'])
        ->pluck('id')
        ->mapWithKeys(function ($id) use ($order_data) {
            return [
                $id => [
                    'quantity' => $order_data['quantity'][$id] ?? 1
                ]
            ];
        })
        ->all();
        $order->foodBoxes()->attach($pairs);

        // Update the order_id in the Product
        $product->order_id = $order->id;
        $product->save();

        session()->forget('order_data');

        return redirect()->route('payment.success');
    }

    public function success()
    {
        return view('payment.success');
    }
}
