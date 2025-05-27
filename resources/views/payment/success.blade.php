<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body>
    <section class="bg-white py-8 dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Payment Successful</h2>
                
                <div class="mt-8 lg:flex lg:gap-12">
                    <div class="w-full rounded-lg border bg-white p-8 shadow dark:border-gray-700 dark:bg-gray-800 lg:w-1/2">
                        <p class="text-lg text-green-600">Thank you for your payment!</p>
                        <p class="mt-4 text-gray-700 dark:text-gray-300">Your transaction has been completed successfully.</p>
                        <a href="{{ route('order.view') }}" class="mt-4 inline-block rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                            Return to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>