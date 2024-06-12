<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('User List') }}
        </h2>
        <a href="{{url('/users/create')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Add Users</a>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full border-collapse table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Role</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-4 py-2 text-center border">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-center border">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-center border">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                                    <td class="px-4 py-2 text-center border">
                                        <a href="{{ route('users.edit', $user->id) }}" class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
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
