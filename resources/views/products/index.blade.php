<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product List') }}
        </h2>
        <a href="{{url('/products/create')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Add Product</a>
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
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Qty</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $products)
                                <tr>
                                    <td class="px-4 py-2 text-center border">{{ $products->p_id }}</td>
                                    <td class="px-4 py-2 text-center border">{{ $products->name }}</td>
                                    <td class="px-4 py-2 text-center border">{{ $products->qty }}</td>
                                    <td class="px-4 py-2 text-center border">{{ $products->price }}</td>
                                    <td class="px-4 py-2 text-center border">
                                        <a href="{{ route('products.edit', $products->id) }}" class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Edit</a>
                                        <form action="{{ route('products.destroy', $products->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
