<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category?->name)" autocomplete="name" placeholder="Name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="slug" :value="__('Slug')"/>
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $category?->slug)" autocomplete="slug" placeholder="Slug"/>
        <x-input-error class="mt-2" :messages="$errors->get('slug')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>