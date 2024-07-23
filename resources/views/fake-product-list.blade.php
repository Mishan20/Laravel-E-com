<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Fake Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm sm:rounded-lg">
                @if($groupedProducts->isNotEmpty())
                    @foreach($groupedProducts as $category => $products)
                        <div class="mb-6">
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">{{ $category }}</h3>
                            @foreach($products as $product)
                                <div class="flex items-center mb-4 border-b border-gray-200">
                                    <div class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        @if(isset($product['image']))
                                            <img src="{{ $product['image'] }}" alt="Product Image" class="object-cover w-16 h-16">
                                        @else
                                            <span>No Image Available</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-gray-900">{{ $product['title'] }}</p>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <p class="text-sm text-gray-700">${{ $product['price'] }}</p>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <p class="text-sm text-gray-700">{{ $product['category'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <p class="text-gray-900">No products available!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>