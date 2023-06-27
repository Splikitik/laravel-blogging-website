<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create new') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Create a new blog.") }}
        </p>
    </header>


    <form method="post" action="{{ route('chirps.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <input type="text" name="status" id="status" value="Pending" hidden>
        <div>
            <x-input-label for="image" :value="__('Attach an image to your blog')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" required autofocus autocomplete="image"/>
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>
        <div class="my-5">
            <x-input-label for="description" :value="__('Write a short description for your blog')" />
            <textarea
                id="description"
                name="description"
                placeholder="{{ __('Write a short description about your blog') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div class="my-5">
            <x-input-label for="message" :value="__('Write the contents of your blog')" />
            <textarea
                rows="10" cols="50"
                id="message"
                name="message"
                placeholder="{{ __('Write contents of your blog') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div class="flex mt-6 items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'blog-posted')
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
</section>