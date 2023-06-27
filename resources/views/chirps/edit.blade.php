<x-app-layout>
    <div class="bg-white max-w-2xl mx-auto mt-10 p-4 sm:p-6 lg:p-8">
        <header>
            <h1 class="text-lg font-medium text-gray-900">
                {{ __('Edit Blog') }}
            </h1>
    
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your blog's information.") }}
            </p>
        </header>

        <form method="post" action="{{ route('chirps.update', $chirp) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('patch')
    
            <div>
                @if($chirp->image === null)
                <img class="w-50 mx-auto" src="../../storage/avatars/placeholder_icon.jpg" alt="UserAvatar">
                    
                @else
                    <img class="w-50 mx-auto" src="../../{{$chirp->image}}" alt="UserAvatar">
    
                @endif
            </div>
    
            <div>
                <x-input-label for="image" :value="__('Add or Update Blog Image')" />
                <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" :value="old('image', $chirp->image)" required  autofocus autocomplete="avatar"/>
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>
    
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
    
                @if (session('status') === 'chirp-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
    <div class="bg-white max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-lg font-medium text-gray-900">
            {{ __('Edit Blog Title') }}
        </h1>
        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('patch')
            <textarea
                name="description"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('description', $chirp->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        
    </div>
    <div class="bg-white max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-lg font-medium text-gray-900">
            {{ __('Edit Blog Information') }}
        </h1>
        
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $chirp->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('chirps.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

    
</x-app-layout>