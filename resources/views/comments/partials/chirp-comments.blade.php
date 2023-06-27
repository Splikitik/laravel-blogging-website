<section>
    <div class="flex-inline px-5 sm:p-6 lg:p-8">
        <div class="flex-inline">
            
                <section>
                    <header>
                        <h2 class="text-xl font-medium text-gray-900">
                            {{ __('Comments') }}
                        </h2>
                    </header>
                
                    <form method="post" action="{{ route('comments.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div class="">
                            <input type="text" name="user_id" value="{{auth()->user()->id}}" hidden>
                            <input type="text" name="blog_id" value="{{$chirp->id}}" hidden>
                            <x-input-label for="message" :value="__('Write your thoughts about this blog.')" />
                            <textarea
                                id="message"
                                name="message"
                                placeholder="{{ __('Write a comment') }}"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>
                        <div class="flex mt-6 items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                
                            @if (session('response') === 'Comment-posted')
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
            @if($comments->count() == 0)
            <div class="mt-5 bg-white max-w-xl mx-auto p-5 border-black rounded-md border">
                <div class="flex justify-center font-bold">
                    <p class="font-bold text-xl text-gray-800 leading-tight mx-auto">
                        {{ __('No Comments Yet!') }}
                    </p>
                </div>
                <div class="flex justify-center font-light">
                    <p class="font-light text-lg text-gray-800 leading-tight mx-auto">
                        {{ __('Be the first one.') }}
                    </p>
                </div>
            </div>
            @endif

            <div class="gap-4 mt-5 px-5">
                {{-- Check if working properly --}}
                @foreach ($comments as $comment)
                @if($comment->blog_id == $chirp->id)
                <div class="m-2 min-w-1/2 bg-white shadow-sm rounded-lg border- border-black-100">
                    <div class="mt-4 p-6 flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <!--Displays the username, date created, and the content-->
                        <div class="flex-1 w-1/2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800">{{ $comment->user->name }}</span>
                                    <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('j M Y, g:i a') }}</small>
                                    @unless ($comment->created_at->eq($comment->updated_at))
                                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                    @endunless
                                </div>
                                <!-- End of chirp contents display-->
                                <!-- Checks if the chirp is made by the current user -->
{{-- Add if admin condition --}}
                                @if ($comment->user->is(auth()->user()))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <form method="POST" action="{{route('comments.edit', $comment)}}">
                                                @method('get')
                                                <input name="id" type="text" value="{{$comment->id}}" hidden>
                                                <x-dropdown-link>
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                            </form>
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                                @csrf
                                                @method('delete')
                                                <input name="id" type="text" value="{{$comment->id}}" hidden>
                                                <x-dropdown-link :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                                <!-- Ned of user checking for edit -->
                            </div>
                            <p class="mt-4 text-lg text-gray-900">{{ $comment->message }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        
        </div>
    </div>
</section>