<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product List') }}
        </h2>
        <a href="{{ url('/products/create') }}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Add Product</a>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Session Messages -->
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="w-full border-collapse table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Category</th>
                                @hasrole('admin')
                                    <th class="px-4 py-2 border">Seller</th>
                                @endhasrole
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Qty</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
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
                                        <a href="{{ route('products.edit', $product->id) }}" class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-2 text-center border">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
