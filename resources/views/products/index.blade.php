<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Product List') }}
                </h2>
            </div>
            <div>
                <a type="button" href="{{ url('/products/export/') }}" class="block px-3 py-2 text-sm font-semibold text-white bg-green-500 rounded-md shadow-sm text-end hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Export') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="sm:flex sm:items-center">
                        <div class="mt-4 mb-4 sm:ml-2 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ url('/products/create') }}" class="block px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md shadow-sm text-end hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Add new Product') }}</a>
                        </div>
                    </div>
                    <!-- Session Messages -->
                    @if (session('success'))
                    <div class="mb-4 text-green-600 notification-popup">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="mb-4 text-red-600 notification-popup">
                        {{ session('error') }}
                    </div>
                    @endif
                    <table class="w-full border-collapse table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 border">{{ __('ID') }}</th>
                                <th class="px-4 py-2 border">{{ __('Category') }}</th>
                                @hasrole('admin')
                                <th class="px-4 py-2 border">{{ __('Seller') }}</th>
                                @endhasrole
                                <th class="px-4 py-2 border">{{ __('Name') }}</th>
                                <th class="px-4 py-2 border">{{ __('Qty') }}</th>
                                <th class="px-4 py-2 border">{{ __('Price') }}</th>
                                <th class="px-4 py-2 border">{{ __('Status') }}</th>
                                <th class="px-4 py-2 border">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="px-4 py-2 text-center border">{{ $product->id }}</td>
                                <td class="px-4 py-2 text-center border">{{ $product->category->name }}</td>
                                @hasrole('admin')
                                <td class="px-4 py-2 text-center border">{{ $product->seller->name ?? 'N/A'}}</td>
                                @endhasrole
                                <td class="px-4 py-2 text-center border">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-center border">{{ $product->qty }}</td>
                                <td class="px-4 py-2 text-center border">{{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-2 text-center border">{{ $product->status() }}</td>
                                <td class="px-4 py-2 text-center border">
                                    <a href="{{ route('products.show', Crypt::encrypt($product->id)) }}" class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">{{ __('View') }}</a>
                                    <a href="{{ route('products.edit', Crypt::encrypt($product->id)) }}" class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">{{ __('Edit') }}</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-2 text-center border">{{ __('No products found.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this product? This action cannot be undone.');
        }
    </script>

    <style>
        .notification-popup {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            z-index: 1000;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</x-app-layout>