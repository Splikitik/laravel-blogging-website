@if(auth()->user()->role != "admin")
<x-app-layout>
    <div class="mt-5 bg-white max-w-xl mx-auto p-5 border-black rounded-md border">
        <div class="flex justify-center font-bold">
            <p class="font-bold text-xl text-gray-800 leading-tight mx-auto">
                {{ __('You do not have permission to acces this page!') }}
            </p>
        </div>
    </div>
</x-app-layout>
    
@else
    <x-app-layout>
        <x-slot name="header">
            <a href="../../admin.dashboard">
                <h2 class="bg-white hover:bg-sky-50 p-4 font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </a>
            
        </x-slot>
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900">
                        <div @class(['p-4', 'font-bold' => true])>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Users') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                            <div class="max-w-xl">
                                <p>Number of Users: {{ $userCount }}</p>
                            </div>
                        </div>
                        <div class="flex -mx-2 max-sm:hidden">
                            <div class="w-1/3 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-emerald-400 h-20 p-5 justify-between items-center border border-black">
                                    <p>Number of Users: {{ $userCount }}</p>
                                </div>
                            </div>
                        </div>
        <div class="my-5 py-12 bg-white">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900">
                        <div id="usersTable" @class(['p-4', 'font-bold' => true])>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Users') }}
                            </h2>
                        </div>
                        
                        <table class="table-fixed min-w-full">
                            <thead>
                                <tr>
                                    <th class="w-1/6 px-4 py-2">Username</th>
                                    <th class="w-2/6 px-4 py-2">Email</th>
                                    <th class="w-1/6 px-4 py-2">Role</th>
                                    <th class="w-2/6 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="even:bg-gray-100 odd:bg-white-100">
                                        <td class="border px-4 py-2">{{$user->name}}</td>
                                        <td class="border px-4 py-2">{{$user->email}}</td>
                                        <td class="border px-4 py-2">
                                            <form method="POST" action="{{route('admin.roleChange')}}">
                                                @csrf
                                                <select name="role" id="role">
                                                    <option @if($user->role == 'admin') selected @endif value="admin">Admin</option>
                                                    <option @if($user->role == 'user') selected @endif value="user">User</option>
                                                </select>
                                        </td>

                                        <td class="border px-4 py-2">
                                            <div class="flex flex-wrap gap-2 justify-center">
                                                    <x-table-action-reject>
                                                        Update
                                                    </x-table-action-reject>
                                                    <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                </form>
                                                <x-table-action-delete
                                                    x-data="{ value: {{$user->id}}}"
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion{{$user->id}}')">
                                                    {{ __('Delete') }}
                                                </x-table-action-delete>
                                                {{-- Modal for user request confirmation --}}
                                                <x-modal name="confirm-user-deletion{{$user->id}}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                                        @csrf

                                                        {{-- Hidden form to send user_id --}}
                                                        <input type="text" name="user_id" value="{{$user->id}}" hidden>

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete this account?') }}
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                                        </p>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ml-3">
                                                                {{ __('Delete') }}
                                                            </x-danger-button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif

