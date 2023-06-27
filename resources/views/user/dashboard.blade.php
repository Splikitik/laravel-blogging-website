<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <div @class(['p-4', 'font-bold' => true])>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Website Statistics') }}
                        </h2>
                    </div>
                      <div>
                        <div class="flex -mx-2">
                            <div class="w-1/3 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-emerald-400 h-20 p-5 justify-between items-center">
                                    <p>Pending Requests: {{ $requestCount }}</p>
                                    <x-hyperlink-button href="#requestsTable">View</x-hyperlink-button>
                                </div>
                             </div>
                          <div class="w-1/3 px-2">
                            <div class="flex font-bold text-xl rounded-lg bg-lime-400 h-20 p-5 justify-between items-center">
                                <p>Number of Users: {{ $userCount }}</p>
                                <x-hyperlink-button href="#usersTable">View</x-hyperlink-button>
                            </div>
                          </div>
                          <div class="w-1/3 px-2">
                            <div class="flex font-bold text-xl rounded-lg bg-teal-400 h-20 p-5 justify-between items-center">
                                <p>Number of Blogs: {{ $chirpCount }}</p>
                                <x-hyperlink-button href="#blogsTable">View</x-hyperlink-button>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="my-5 py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <div id="requestsTable" class="p-4 font-bold">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Requests') }}
                        </h2>
                    </div>
                    <table class="table-fixed min-w-full">
                        <thead>
                            <tr>
                                <th class="w-1/6 px-4 py-2">Request Type</th>
                                <th class="w-1/6 px-4 py-2">Request Status</th>
                                <th class="w-1/6 px-4 py-2">Requester</th>
                                <th class="w-1/6 px-4 py-2">Requested On</th>
                                <th class="w-2/6 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr class="even:bg-gray-100 odd:bg-white-100">
                                    <td class="border px-4 py-2">{{$request->request_type}}</td>
                                    <td class="border px-4 py-2">{{$request->request_status}}</td>
                                    <td class="border px-4 py-2">{{$request->user->name}}</td>
                                    <td class="border px-4 py-2">{{$request->created_at}}</td>
                                    <td class="border px-4 py-2">
                                        <div class="inline-flex">
                                            <form method="POST" action="{{route('admin.accept')}}">
                                                @csrf
                                                <x-table-action-accept>
                                                    Accept
                                                </x-table-action-accept>
                                                <input type="text" name="request_id" value="{{$request->id}}" hidden>
                                            </form>
                                            <form method="POST" action="{{route('admin.reject')}}">
                                                @csrf
                                                <x-table-action-reject>
                                                    Reject
                                                </x-table-action-reject>
                                                <input type="text" name="request_id" value="{{$request->id}}" hidden>
                                            </form>
                                            <x-table-action-delete
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-request-deletion')">
                                                {{ __('Delete') }}
                                            </x-table-action-delete>
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

    <hr>
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
                                <th class="w-1/6 px-4 py-2">Email</th>
                                <th class="w-1/6 px-4 py-2">Role</th>
                                <th class="w-1/6 px-4 py-2">Account Status</th>
                                <th class="w-2/6 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="even:bg-gray-100 odd:bg-white-100">
                                    <td class="border px-4 py-2">{{$user->name}}</td>
                                    <td class="border px-4 py-2">{{$user->email}}</td>
                                    <td class="border px-4 py-2">{{__('User')}}</td>
                                    <td class="border px-4 py-2">{{__('Verified')}}</td>
                                    <td class="border px-4 py-2">
                                        <div class="inline-flex">
                                            <form method="POST" action="{{route('admin.accept')}}">
                                                @csrf
                                                <x-table-action-accept>
                                                    Accept
                                                </x-table-action-accept>
                                                <input type="text" name="request_id" value="{{$request->id}}" hidden>
                                            </form>
                                            <form method="POST" action="{{route('admin.reject')}}">
                                                @csrf
                                                <x-table-action-reject>
                                                    Reject
                                                </x-table-action-reject>
                                                <input type="text" name="request_id" value="{{$request->id}}" hidden>
                                            </form>
                                            <x-table-action-delete
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                                {{ __('Delete') }}
                                            </x-table-action-delete>
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

    <hr>
    <div class="my-5 py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <div id="blogsTable" @class(['p-4', 'font-bold' => true])>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Blogs') }}
                        </h2>
                    </div>
                    <table class="table-fixed min-w-full">
                        <thead>
                            <tr>
                                <th class="w-1/2 px-4 py-2">Blog Title</th>
                                <th class="w-1/4 px-4 py-2">Blog Description</th>
                                <th class="w-1/4 px-4 py-2">Created By:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chirps as $chirp)
                                <tr class="even:bg-gray-100 odd:bg-white-100">
                                    <td class="border px-4 py-2">{{$chirp->message}}</td>
                                    <td class="border px-4 py-2">{{$chirp->id}}</td>
                                    <td class="border px-4 py-2">{{$chirp->user->name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

{{-- Modal for delete request confirmation --}}
<x-modal name="confirm-request-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('admin.delete') }}" class="p-6">
        @csrf

        {{-- Hidden form to send request_id --}}
        <input type="text" name="request_id" value="{{$request->id}}" hidden>

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this request?') }}
        </h2>

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

{{-- Modal for user request confirmation --}}
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('admin.delete') }}" class="p-6">
        @csrf

        {{-- Hidden form to send request_id --}}
        <input type="text" name="request_id" value="{{$request->id}}" hidden>

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
</x-app-layout>
