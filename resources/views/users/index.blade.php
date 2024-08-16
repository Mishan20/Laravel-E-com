<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="sm:flex sm:items-center">
                        <div class="mt-4 mb-4 sm:ml-2 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ url('/users/create') }}" class="block px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md shadow-sm text-end hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Add new User') }}</a>
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
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
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

    <!-- Pusher Notification Script -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable Pusher logging - disable in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ config("services.pusher.key") }}', {
            cluster: '{{ config("services.pusher.options.cluster") }}',
        });

        var channel = pusher.subscribe('mishan-ecom');
        channel.bind('new-user-registered', function(data) {
            showNotification('New user has registered.');
        });

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification-popup';
            notification.innerText = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 6000); // 1 minute
        }
    </script>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this user? This action cannot be undone.');
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