<x-app-layout>
    <div class="bg-white max-w-2xl mx-auto mt-10 p-4 sm:p-6 lg:p-8">
        <header>
            <h1 class="text-lg font-medium text-gray-900">
                {{ __('Edit Comment') }}
            </h1>
    
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Edit your comment") }}
            </p>
        </header>
    </div>
    <div class="bg-white max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('comments.update', $comments) }}">
            @csrf
            <input name="id" type="text" value="{{$id}}" hidden>
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $message) }}</textarea>
            <div class="mt-5">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
        </form>
    </div>
</x-app-layout>