<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit User') }}
        </h2>
        <a href="{{url('/users')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Back to Users List</a>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm overflow-hiden sm:rounded-lg">
                <div class="p-6 text-gray-900"></div>
                <form action="{{ route('users.update', $user->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name') ?? $user->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email') ?? $user->email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        @php
                        $roles = ['admin', 'seller', 'buyer'];
                        @endphp
                        <x-input-label for="role" :value="__('Role')" />
                        <select name="role" id="role" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($roles as $role)
                            <option value="{{ $role }}" {{ (old('role') ?? $user->getRoleNames()->first()) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="mt-4">
                            {{ __('Edit User') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>