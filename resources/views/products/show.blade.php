<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product Details') }}
        </h2>
        <!-- <a href="{{ url('/products') }}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Product List</a> -->
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow-md">
                        @if($product->image)
                        <!-- <img class="object-cover w-full h-48 rounded-t-lg" src="{{ asset('storage/' . $product->image) }}" alt="Product Image"> -->
                        <img class="object-cover w-full h-48 rounded-t-lg" src="{{ $product->image() }}" alt="Product Image">
                        @else
                        <img class="object-cover w-full h-48 rounded-t-lg" src="{{ asset('images/default-product.png') }}" alt="Default Image">
                        @endif
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h5>
                            <p class="mb-3 font-normal text-gray-700"><strong>Product ID:</strong> {{ $product->p_id }}</p>
                            <p class="mb-3 font-normal text-gray-700"><strong>Category:</strong> {{ $product->category->name }}</p>
                            <p class="mb-3 font-normal text-gray-700"><strong>Quantity:</strong> {{ $product->qty }}</p>
                            <p class="mb-3 font-normal text-gray-700"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                            <a href="{{ url('/products') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Back to Product List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
