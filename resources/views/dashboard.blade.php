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
            <div class="flex text-center w-100">
                @if (Auth::user()->hasRole(['seller', 'admin']))
                    <div class="w-1/3 p-5 bg-red-100">Seller and Admin</div>
                @endif
                
                @if (Auth::user()->hasRole(['buyer', 'admin']))
                    <div class="w-1/3 p-5 bg-green-100">Buyer and Admin</div>
                @endif
                
                @if (Auth::user()->hasRole('admin'))
                    <div class="w-1/3 p-5 bg-blue-100">Admin</div>
                @endif
                <!-- @hasRole('admin')
                @endhasRole

                @role('admin')
                @endrole -->
            </div>
        </div>
    </div>
</x-app-layout>
