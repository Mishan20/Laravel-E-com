<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm sm:rounded-lg">
                @if(session('cart'))
                @foreach($cart as $item)
                <div class="flex items-center mb-4 border-b border-gray-200">
                    <div class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                        @if(isset($item['image']))
                        <img src="{{ $item['image'] }}" alt="Product Image" class="object-cover w-16 h-16">
                        @else
                        <span>No Image Available</span>
                        @endif
                    </div>
                    <div class="flex-1 ml-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                            <form action="{{ route('cart.remove', $item['product_id']) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </div>
                        <div class="flex items-center mt-2">
                            <form action="{{ route('cart.update', $item['product_id']) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="operation" value="decrease">
                                <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-700">-</button>
                            </form>
                            <p class="mx-2 text-gray-900">{{ $item['quantity'] }}</p>
                            <form action="{{ route('cart.update', $item['product_id']) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="operation" value="increase">
                                <button type="submit" class="px-2 py-1 text-white bg-green-500 rounded hover:bg-green-700">+</button>
                            </form>
                            <p class="ml-4 text-sm text-gray-700">${{ $item['price'] }}</p>
                            <p class="ml-4 text-sm font-medium text-gray-900">${{ $item['itemTotal'] }}</p>
                            <!-- Display item total -->
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-6 text-right">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Total: ${{ $total }}
                    </h2>
                </div>
                <div>
                    <a href="{{ url('/stripe') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Checkout</a>
                </div>
                @else
                <div class="text-center">
                    <p class="text-gray-900">Your cart is empty!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>