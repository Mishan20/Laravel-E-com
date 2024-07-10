<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2> -->
        <!-- @if (Auth::user()->hasRole(['admin']))
        <a href="{{url('/users/create')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Add Users</a>
        @endif
        @if (Auth::user()->hasRole(['seller']))
        <a href="{{url('/products/create')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Add Product</a>
        @endif -->
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- @if (Auth::user()->hasRole(['seller', 'admin']))
                    <div class="w-1/3 p-5 bg-red-100">Seller and Admin</div>
                @endif
                
                @if (Auth::user()->hasRole(['buyer', 'admin']))
                    <div class="w-1/3 p-5 bg-green-100">Buyer and Admin</div>
                @endif
                
                @if (Auth::user()->hasRole('admin'))
                    <div class="w-1/3 p-5 bg-blue-100">Admin</div>
                @endif -->
            <!-- @hasRole('admin')
                @endhasRole

                @role('admin')
                @endrole -->
            <div class="mb-8">
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
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Search by name or category..." class="block w-full px-4 py-2 mr-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Search</button>
                </form>
            </div>

            @if(request('query'))
            <div class="mb-8">
                <h2 class="mb-4 text-2xl font-semibold leading-tight text-gray-800">Search Results</h2>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                        <img class="object-cover object-center w-full h-48" src="{{ $product->image() }}" alt="Product Image">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">Category: {{ $product->category->name }}</p>
                                </div>
                                <div class="text-lg font-bold">
                                    <p>${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <button class="w-full px-4 py-2 font-bold text-white bg-blue-500 hover:bg-blue-700">Add to Cart</button>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            @foreach($categories as $category)
            <div class="mb-8">
                <h2 class="mb-4 text-2xl font-semibold leading-tight text-gray-800">{{ $category->name }}</h2>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($category->products as $product)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                        <!-- <img class="object-cover object-center w-full h-48" src="{{ asset('storage/'.$product->image) }}" alt="Product Image"> -->
                        <img class="object-cover object-center w-full h-48" src="{{ $product->image() }}" alt="Product Image">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">Category: {{ $category->name }}</p>
                                </div>
                                <div class="text-lg font-bold">
                                    <p>${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('add-to-cart', [$product->id]) }}" method="POST">
                            @csrf
                            <button class="w-full px-4 py-2 font-bold text-white bg-blue-500 hover:bg-blue-700">Add to Cart</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>


    <script src="https://js.pusher.com/8.2.0/pusher.min.js">
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        });

        var channel = pusher.subscribe('new-user-register');
        channel.bind('App\\Events\\NewUserRegisterEvent', function(data) {
            console.log(data);
            // Do What You Want With Data
            // I Will Be Enough With Print It On Console
        });
    </script>
</x-app-layout>