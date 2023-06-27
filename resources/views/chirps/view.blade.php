<x-app-layout>
    <div class="mx-auto w-3/4 p-4 sm:p-6 lg:p-8">
        <div class="flex-inline">
            <div class="gap-4 mt-5 justify-center items-center text-center">
                <div class="bg-white shadow-sm rounded-lg border- border-black-100">
                    <div class="p-5 mt-5">
                    @foreach($chirps as $chirp)
                    <div class="justify-left align-left text-left self-start">
                        <x-hyperlink-button href="{{route('chirps.index')}}"><- Back</x-hyperlink-button>
                    </div>
                        <div class="flex flex-inline">
                            <div class="text-center mx-auto">
                                <span class="ml-4 text-6xl text-gray-800">{{ $chirp->description }}</span>
                            </div>
                        <!-- Checks if the chirp is made by the current user -->
                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <form method="GET" action="{{ route('chirps.edit', $chirp) }}">
                                            @csrf
                                            <x-dropdown-link :href="route('chirps.edit', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                        </form>
                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                            </div>
                        </div>
                    <div>
                        <div class="ml-8 text-left">
                            <span class="ml-4 text-lg text-gray-800">{{__('Posted by: ')}}{{ $chirp->user->name }}</span>
                        </div>
                        <div class="ml-8 text-left">
                            <small class="ml-4 text-base text-gray-600">{{__('Posted on: ')}}{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($chirp->created_at->eq($chirp->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                    </div>
                    </div>
                    <div class="p-5">
                        {{-- Need to change to blog_image --}}
                        <img src="../../{{$chirp->image}}" class="object-cover w-1/2 mx-auto" alt="">
                    </div>
                    <div class="p-6 flex space-x-2">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg> --}}
                        <!--Displays the username, date created, and the content-->
                        <hr>
                        <div class="flex-1 border border-black-10">
                            <p class="p-5 text-lg text-gray-900 text-left">{{ $chirp->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    @foreach($chirps as $chirp)
        <div class="mx-auto w-3/4">
            @include('comments.partials.chirp-comments');
        </div>
    @endforeach
</x-app-layout>