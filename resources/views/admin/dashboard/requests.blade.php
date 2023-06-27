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
                                {{ __('Pending Requests') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                            <div class="max-w-xl">
                                <p>Pending Requests: {{ $pendingCount }}</p>
                            </div>
                        </div>
                        <div class="flex -mx-2 max-sm:hidden">
                            <div class="w-1/3 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-emerald-400 h-20 p-5 justify-between items-center border border-black">
                                    <p>Pending Requests: {{ $pendingCount }}</p>
                                </div>
                            </div>
                        </div>
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
                                                        <th class="w-1/4 px-4 py-2">Requester</th>
                                                        <th class="w-1/4 px-4 py-2">Request Status</th>
                                                        <th class="w-1/4 px-4 py-2">Requested On</th>
                                                        <th class="w-2/5 px-4 py-2">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pendingRequests as $request)
                                                        <tr class="even:bg-gray-100 odd:bg-white-100">
                                                            <td class="border px-4 py-2">{{$request->user->name}}</td>
                                                            <td class="border px-4 py-2">{{$request->request_status}}</td>
                                                            <td class="border px-4 py-2">{{$request->created_at}}</td>
                                                            <td class="border px-4 py-2">
                                                                <!-- Hamburger -->
                                                                <x-table-action-accept
                                                                    x-data=""
                                                                    x-on:click.prevent="$dispatch('open-modal', 'open-actions-{{$request->id}}')"
                                                                    class=" md:hidden">
                                                                    {{ __('Actions') }}
                                                                </x-table-action-accept>
                                                                <x-modal name="open-actions-{{$request->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                                    <h2 class="p-4 font-semibold text-xl text-gray-800 leading-tight">
                                                                        {{ __('Select an Action') }}
                                                                    </h2>
                                                                    <div class="flex inline-flex p-5 -pt-5">
                                                                        <a href="../../chirps/{{$request->blog_id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                            View
                                                                        </a>
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
                                                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-request-deletion{{$request->id}}')">
                                                                            {{ __('Delete') }}
                                                                        </x-table-action-delete>
                                                                    </div>
                                                                </x-modal>
                                                                <div class="inline-flex max-md:hidden">
                                                                    <a href="../../chirps/{{$request->blog_id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                        View
                                                                    </a>
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
                                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-request-deletion{{$request->id}}')">
                                                                        {{ __('Delete') }}
                                                                    </x-table-action-delete>
                                                                    {{-- Modal for delete request confirmation --}}
                                                                    <x-modal name="confirm-request-deletion{{$request->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                                        <form method="post" action="{{ route('admin.delete') }}" class="p-6">
                                                                            @csrf
                    
                                                                            {{-- Hidden form to send request_id --}}
                                                                            @if(!$requestCount == 0)
                                                                                <input type="text" name="request_id" value="{{$request->id}}" hidden>
                                                                            @endif
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif