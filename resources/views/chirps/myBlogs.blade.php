<x-app-layout>
    <div class="flex-inline p-4 sm:p-6 lg:p-8">
        <div class="flex-inline">
            <div class="flex justify-center font-bold">
                <p class="font-bold text-xl text-gray-800 leading-tight mx-auto">
                    {{ __('My Blogs') }}
                </p>
            </div>
            <div class="w-1/2 mx-auto">
                <form method="POST" action="{{route('chirps.search')}}" class="flex items-center p-1 mt-4">   
                    @csrf
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input name="title" type="text" id="simple-search" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
                    </div>
                    <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>
            @if($chirps->count() == 0)
            <div class="bg-white max-w-xl mt-5 mx-auto p-5 border-black rounded-md border">
                <div class="flex justify-center font-bold">
                    <p class="font-bold text-xl text-gray-800 leading-tight mx-auto">
                        {{ __('You don\'t have any blogs yet!') }}
                    </p>
                </div>
                <div class="flex justify-center font-light">
                    <p class="font-light text-lg text-gray-800 leading-tight mx-auto">
                        {{ __('Create your first one.') }}
                    </p>
                </div>
                <div class="mt-4 text-center">
                    <x-hyperlink-button href="{{route('chirps.create')}}">Go -></x-hyperlink-button>
                </div>
            </div>
            
            @endif
            <div class="flex flex-wrap gap-4 mt-5 justify-center">
                @foreach ($chirps as $chirp)
                <div class="xl:w-1/5 lg:w-1/4 md:w-1/3 sm:w-1/2 bg-white shadow-sm rounded-lg border- border-black-100">
                    <div class="pt-6">
                        <p class="text-center text-xl text-gray-900 font-bold">{{ $chirp->description }}</p>
                    </div>
                    <div class="mt-2">
                        {{-- Need to change to blog_image --}}
                        <img src="{{$chirp->image}}" class="object-contain h-48 w-96 mx-auto" alt="">
                    </div>
                    <div class="p-6 flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <!--Displays the username, date created, and the content-->
                        <div class="flex-1">
                            <div class="flex">
                                <div>
                                    <div>
                                        <span class="text-gray-800">{{__('By: ')}}{{ $chirp->user->name }}</span>
                                    </div>
                                    <div>
                                        <small class="text-sm text-gray-600">{{$chirp->created_at->format('j M Y, g:i a') }}</small>
                                        @unless ($chirp->created_at->eq($chirp->updated_at))
                                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                        @endunless
                                    </div>
                                    <small class="mx-auto text-sm text-gray-600">{{__('Status: ')}}{{$chirp->status }}</small>
                                </div>
                                <!-- End of chirp contents display-->
                                <!-- Checks if the chirp is made by the current user -->
                                <div class="mx-auto">
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
                                <div>
                                <!-- Ned of user checking for edit -->
                            </div>
                        </div>
                    </div>
                    <div class="pt-5">
                        <x-hyperlink-button href="../chirps/{{$chirp->id}}/view">View</x-hyperlink-button>
                    </div>
                </div>
                
            </div>
            
        </div>
        @endforeach
    </div>
</x-app-layout>