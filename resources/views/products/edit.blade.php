<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Product') }}
        </h2>
        <a href="{{url('/products')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Back to Product List</a>  
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm overflow-hiden sm:rounded-lg">
                <div class="p-6 text-gray-900"></div>
                <form action="{{ route('products.update', $product->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="p_id" :value="__('Product ID')" />
                        <x-text-input id="p_id"  class="block w-full mt-1" type="text" name="p_id" :value="old('p_id') ?? $product->p_id" required autocomplete="" />
                        <x-input-error :messages="$errors->get('p_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name') ?? $product->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="number" :value="__('Quantity')" />
                        <x-text-input id="qty"  class="block w-full mt-1" type="number" name="qty" :value="old('quantity') ?? $product->qty" required autocomplete="" />
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="number" :value="__('Price')" />
                        <x-text-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price') ?? $product->price" required autocomplete="new-price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="mt-4">
                            {{ __('Edit Product') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>