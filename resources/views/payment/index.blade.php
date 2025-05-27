<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/" crossorigin="anonymous"></script>
    <style>
        input {
            font-size: 1rem; /* Increase font size */
            color: #ffffff; /* Set text color to white for better contrast */
            background-color: #2d3748; /* Set a darker background color */
            border: 1px solid #4a5568; /* Add a border for better visibility */
            padding: 0.75rem; /* Add padding for better spacing */
            border-radius: 0.375rem; /* Add rounded corners */
        }

        input::placeholder {
            color: #a0aec0; /* Set placeholder text color */
        }

        input:focus {
            outline: none; /* Remove default focus outline */
            border-color: #63b3ed; /* Add a blue border on focus */
            box-shadow: 0 0 0 3px rgba(99, 179, 237, 0.5); /* Add a subtle focus shadow */
        }
    </style>
</head>
<body>
    <section class="bg-gray-100 py-12 dark:bg-gray-900">
        <div class="mx-auto max-w-screen-xl px-4">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Payment</h2>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="lg:flex lg:gap-12">
                    {{-- Payment Form --}}
                    <form id="payment-form"
                        class="w-full rounded-lg border bg-white p-8 shadow-lg dark:border-gray-700 dark:bg-gray-800 lg:w-1/2"
                        novalidate>
                        @csrf

                        {{-- Cardholder Name --}}
                        <div class="mb-6">
                            <label for="cardholder-name" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Full Name*
                            </label>
                            <input id="cardholder-name" name="cardholder-name" type="text" required
                                class="mt-1 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Bonnie Green">
                        </div>

                        {{-- Card Number --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                Card Number*
                            </label>
                            <div id="card-number-element"
                                class="mt-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <!-- Stripe CardNumber Element -->
                            </div>
                        </div>

                        {{-- Expiry Date --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                Expiration Date*
                            </label>
                            <div id="card-expiry-element"
                                class="mt-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <!-- Stripe CardExpiry Element -->
                            </div>
                        </div>

                        {{-- CVC --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                CVC*
                            </label>
                            <div id="card-cvc-element"
                                class="mt-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <!-- Stripe CardCvc Element -->
                            </div>
                        </div>

                        {{-- Error Display --}}
                        <div id="card-errors" role="alert" class="text-red-600 mb-4 text-sm"></div>

                        {{-- Submit Button --}}
                        <button type="submit"
                                class="w-full rounded-lg bg-blue-600 py-3 text-white font-semibold shadow-lg hover:bg-blue-700 focus:ring focus:ring-blue-200">
                            Pay RM {{ number_format($price, 2) }}
                        </button>
                    </form>

                    {{-- Saved Payment Methods --}}
                    <div class="mt-8 lg:mt-0 lg:w-1/2">
                        @if (count($paymentMethods) > 0)
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Saved Payment Methods</h3>
                            <ul class="space-y-4">
                                @foreach ($paymentMethods as $method)
                                    <li class="flex items-center justify-between rounded-lg border border-gray-300 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-800">
                                        <div>
                                            <span class="text-gray-800 dark:text-gray-200 font-medium">
                                                **** **** **** {{ $method->card->last4 }}
                                            </span>
                                            <span class="block text-gray-800 dark:text-gray-200 font-medium">
                                                {{ ucfirst($method->card->brand) }}
                                            </span>
                                            <span class="block text-sm text-gray-500 dark:text-gray-400">
                                                Expires {{ $method->card->exp_month }}/{{ $method->card->exp_year }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            {{-- Use this card button --}}
                                            <form action="{{ route("payment.pay") }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_method_id" value="{{ $method->id }}">   
                                                <button type="submit" class="text-blue-600 font-medium hover:underline">
                                                    Use this card
                                                </button> 
                                            </form>
                                            {{-- Delete button --}}
                                            <form action="{{ route("payment.delete") }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_method_id" value="{{ $method->id }}">   
                                                <button type="submit" class="text-red-600 font-medium hover:underline">
                                                    Delete
                                                </button> 
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No saved payment methods found. Please add a new payment method.</p>
                        @endif

                        {{-- Order Summary --}}
                        <div class="mt-8 rounded-lg border border-gray-300 bg-white p-6 shadow-sm dark:border-gray-600 dark:bg-gray-800">
                            <dl class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Original Price</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">RM {{ number_format($price, 2) }}</dd>
                            </dl>
                            <dl class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Additional Charges</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">RM 0.00</dd>
                            </dl>
                            <dl class="mt-2 flex justify-between border-t pt-2">
                                <dt class="font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="font-bold text-gray-900 dark:text-white">RM {{ number_format($price, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe('{{ $publishableKey }}');

        const elements = stripe.elements();
        const style = {
            base: {
                color: '#ffffff',
                fontSize: '16px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#a0aec0',
                },
            },
            invalid: {
                color: '#e53e3e',
                iconColor: '#e53e3e',
            },
        };

        const cardNumber = elements.create('cardNumber', { style });
        cardNumber.mount('#card-number-element');
        const cardExpiry = elements.create('cardExpiry', { style });
        cardExpiry.mount('#card-expiry-element');
        const cardCvc = elements.create('cardCvc', { style });
        cardCvc.mount('#card-cvc-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardNumber,
                billing_details: {
                    name: document.getElementById('cardholder-name').value,
                },
            });

            if (error) {
                console.error('Error creating payment method:', error.message);
                document.getElementById('card-errors').textContent = error.message;
                return;
            }

            console.log('Payment Method ID:', paymentMethod.id);

            // Create a hidden form and submit it (which expects HTML response)
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("payment.pay") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfInput);

            // Add payment method ID
            const paymentMethodInput = document.createElement('input');
            paymentMethodInput.type = 'hidden';
            paymentMethodInput.name = 'payment_method_id';
            paymentMethodInput.value = paymentMethod.id;
            form.appendChild(paymentMethodInput);

            // Submit the form
            document.body.appendChild(form);
            form.submit();
        });
    });
    </script>
</body>
</html>