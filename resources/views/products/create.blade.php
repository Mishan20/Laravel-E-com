<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add Product') }}
        </h2>
        <a href="{{url('/products')}}" class="px-2 py-1 font-bold text-right text-white bg-blue-500 rounded hover:bg-blue-700">Product List</a>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm overflow-hiden sm:rounded-lg">
                <div class="p-6 text-gray-900"></div>
                <form action="{{ route('products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="p_id" :value="__('Product ID')" />
                        <x-text-input id="p_id" class="block w-full mt-1" type="text" name="p_id" :value="old('id')"  autocomplete="" />
                        <x-input-error :messages="$errors->get('p_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')"  autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="number" :value="__('Quantity')" />
                        <x-text-input id="qty" class="block w-full mt-1" type="number" name="qty" :value="old('qty')"  autocomplete="" />
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="number" :value="__('Price')" />
                        <x-text-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price')"  autocomplete="new-price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <input type="file" name="image" id="image" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"> 
                        {{-- <x-text-input id="image" class="block w-full mt-1" type="file" name="image" :value="old('image')"  autocomplete="new-image" /> --}}
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="mt-4">
                            {{ __('Add Product') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

      <!-- Include Dropzone.js -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <!-- Initialize Dropzone -->
    <script>
        Dropzone.options.imageDropzone = {
            url: "{{ route('products.store') }}",
            maxFilesize: 2, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            autoProcessQueue: false,
            init: function() {
                var myDropzone = this;

                // Prevent the form from being submitted normally
                document.querySelector("#product-dropzone").addEventListener("submit", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Process the images
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        myDropzone.uploadFiles([]);
                    }
                });

                // On success, redirect or perform another action
                myDropzone.on("success", function(file, response) {
                    window.location.href = "{{ route('products.index') }}";
                });
            }
        };
    </script>
</x-app-layout>