<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile avatar.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.avatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            @if($user->avatar === null)
                <img class="w-40 h-40" src="{{"storage/avatars\placeholder_icon.jpg"}}" alt="UserAvatar">
                
            @else
                <img class="w-40 h-40" src="{{$user->avatar}}" alt="UserAvatar">

            @endif
        </div>

        <div>
            <x-input-label for="avatar" :value="__('Add or Update Avatar')" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->name)" required  autofocus autocomplete="avatar"/>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
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
