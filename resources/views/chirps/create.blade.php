<x-app-layout>
    <div class="mt-10 max-w-2xl mx-auto">
        <div class="flex justify-center p-4 font-bold">
            <p class="font-bold text-xl text-gray-800 leading-tight mx-auto">
                {{ __('Create New') }}
            </p>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('chirps.partials.new-blog-image')
            </div>
        </div>
    </div>
    

</x-app-layout>