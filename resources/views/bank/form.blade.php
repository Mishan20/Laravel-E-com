<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $bank?->name)" autocomplete="name" placeholder="Name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="phone" :value="__('Phone')"/>
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $bank?->phone)" autocomplete="phone" placeholder="Phone"/>
        <x-input-error class="mt-2" :messages="$errors->get('phone')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>