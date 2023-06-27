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
                                {{ __('Blogs') }}
                            </h2>
                        </div>
                        <div>
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                                <div class="max-w-xl">
                                    <p>Number of Accepted Blogs: {{ $acceptedCount }}</p>
                                    <x-hyperlink-button href="#acceptedTable">Go</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                                <div class="max-w-xl">
                                    <p>Number of Rejected Blogs: {{ $rejectedCount }}</p>
                                    <x-hyperlink-button href="#rejectedTable">Go</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="flex -mx-2 max-sm:hidden">
                                <div class="w-1/2 px-2">
                                    <div class="flex font-bold text-xl rounded-lg bg-emerald-400 h-20 p-5 justify-between items-center border border-black">
                                        <p>Number of Accepted Blogs: {{ $acceptedCount }}</p>
                                        <x-hyperlink-button href="#acceptedTable">Go</x-hyperlink-button>
                                    </div>
                                </div>
                            <div class="w-1/2 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-lime-400 h-20 p-5 justify-between items-center border border-black">
                                    <p>Number of Rejected Blogs: {{ $rejectedCount }}</p>
                                    <x-hyperlink-button href="#rejectedTable">Go</x-hyperlink-button>
                                </div>
                            </div>
                        </div>
                            <hr>
        
            <div class="my-5 py-12 bg-white">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="text-gray-900">
                            <div id="acceptedTable" @class(['p-4', 'font-bold' => true])>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('Accepted Blogs') }}
                                </h2>
                            </div>
                            <table class="table-fixed min-w-full">
                                <thead>
                                    <tr>
                                        <th class="w-1/4 px-4 py-2">Blog Title</th>
                                        <th class="w-1/4 px-4 py-2">Created By:</th>
                                        <th class="w-1/4 px-4 py-2">Status</th>
                                        <th class="w-2/5 px-4 py-2">Actions:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chirpAccepted as $chirp)
                                        <tr class="even:bg-gray-100 odd:bg-white-100">
                                            <td class="border px-4 py-2">{{$chirp->description}}</td>
                                            <td class="border px-4 py-2">{{$chirp->user->name}}</td>
                                            <td class="border px-4 py-2">{{$chirp->status}}</td>
                                            <td class="border px-4 py-2">
                                                <!-- Hamburger -->
                                                <x-table-action-accept
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'open-actions-{{$chirp->id}}')"
                                                        class=" md:hidden">
                                                        {{ __('Actions') }}
                                                </x-table-action-accept>
                                                <x-modal name="open-actions-{{$chirp->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                    <h2 class="p-4 font-semibold text-xl text-gray-800 leading-tight">
                                                        {{ __('Select an Action') }}
                                                    </h2>
                                                    <div class="flex inline-flex p-5 -pt-5">
                                                        <a href="../../chirps/{{$chirp->id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            View
                                                        </a>
                                                        </form>
                                                        <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                            @csrf
                                                            <x-table-action-accept>
                                                                Accept
                                                            </x-table-action-accept>
                                                            <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            <input type="text" name="status" value="Accepted" hidden>
                                                        </form>
                                                        <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                            @csrf
                                                            <x-table-action-reject>
                                                                Reject
                                                            </x-table-action-reject>
                                                            <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            <input type="text" name="status" value="Rejected" hidden>
                                                        </form>
                                                        <x-table-action-delete
                                                            x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion{{$chirp->id}}')">
                                                            {{ __('Delete') }}
                                                        </x-table-action-delete>
                                                    </div>
                                                </x-modal>
                                                <div class="flex inline-flex max-md:hidden">
                                                    <a href="../../chirps/{{$chirp->id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        View
                                                    </a>
                                                    </form>
                                                    <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                        @csrf
                                                        <x-table-action-accept>
                                                            Accept
                                                        </x-table-action-accept>
                                                        <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                        <input type="text" name="status" value="Accepted" hidden>
                                                    </form>
                                                    <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                        @csrf
                                                        <x-table-action-reject>
                                                            Reject
                                                        </x-table-action-reject>
                                                        <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                        <input type="text" name="status" value="Rejected" hidden>
                                                    </form>
                                                    <x-table-action-delete
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion{{$chirp->id}}')">
                                                        {{ __('Delete') }}
                                                    </x-table-action-delete>
                                                    {{-- Modal for delete request confirmation --}}
                                                    <x-modal name="confirm-blog-deletion{{$chirp->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                        <form method="post" action="{{ route('chirps.destroy', $chirp) }}" class="p-6">
                                                            @csrf
                                                            @method('delete')

                                                            {{-- Hidden form to send request_id --}}
                                                            @if(!$chirpCount == 0)
                                                                <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            @endif
                                                            <h2 class="text-lg font-medium text-gray-900">
                                                                {{ __('Are you sure you want to delete this blog?') }}
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
        
            <div class="my-5 py-12 bg-white">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="text-gray-900">
                            <div id="rejectedTable" @class(['p-4', 'font-bold' => true])>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('Rejected Blogs') }}
                                </h2>
                            </div>
                            <table class="table-fixed min-w-full">
                                <thead>
                                    <tr>
                                        <th class="w-1/4 px-4 py-2">Blog Title</th>
                                        <th class="w-1/4 px-4 py-2">Created By:</th>
                                        <th class="w-1/4 px-4 py-2">Status</th>
                                        <th class="w-2/5 px-4 py-2">Actions:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chirpRejected as $chirp)
                                        <tr class="even:bg-gray-100 odd:bg-white-100">
                                            <td class="border px-4 py-2">{{$chirp->description}}</td>
                                            <td class="border px-4 py-2">{{$chirp->user->name}}</td>
                                            <td class="border px-4 py-2">{{$chirp->status}}</td>
                                            <td class="border px-4 py-2">
                                                <!-- Hamburger -->
                                                <x-table-action-accept
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'open-actions-{{$chirp->id}}')"
                                                        class=" md:hidden">
                                                        {{ __('Actions') }}
                                                </x-table-action-accept>
                                                <x-modal name="open-actions-{{$chirp->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                    <h2 class="p-4 font-semibold text-xl text-gray-800 leading-tight">
                                                        {{ __('Select an Action') }}
                                                    </h2>
                                                    <div class="flex inline-flex p-5 -pt-5">
                                                        <a href="../../chirps/{{$chirp->id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            View
                                                        </a>
                                                        </form>
                                                        <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                            @csrf
                                                            <x-table-action-accept>
                                                                Accept
                                                            </x-table-action-accept>
                                                            <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            <input type="text" name="status" value="Accepted" hidden>
                                                        </form>
                                                        <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                            @csrf
                                                            <x-table-action-reject>
                                                                Reject
                                                            </x-table-action-reject>
                                                            <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            <input type="text" name="status" value="Rejected" hidden>
                                                        </form>
                                                        <x-table-action-delete
                                                            x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion{{$chirp->id}}')">
                                                            {{ __('Delete') }}
                                                        </x-table-action-delete>
                                                    </div>
                                                </x-modal>
                                                <div class="inline-flex max-md:hidden">
                                                    <a href="../../chirps/{{$chirp->id}}/view" class="inline-flex items-center mx-1 px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        View
                                                    </a>
                                                    </form>
                                                    <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                        @csrf
                                                        <x-table-action-accept>
                                                            Accept
                                                        </x-table-action-accept>
                                                        <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                        <input type="text" name="status" value="Accepted" hidden>
                                                    </form>
                                                    <form method="POST" action="{{route('chirps.statusUpdate')}}">
                                                        @csrf
                                                        <x-table-action-reject>
                                                            Reject
                                                        </x-table-action-reject>
                                                        <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                        <input type="text" name="status" value="Rejected" hidden>
                                                    </form>
                                                    <x-table-action-delete
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion{{$chirp->id}}')">
                                                        {{ __('Delete') }}
                                                    </x-table-action-delete>
                                                    
                                                    {{-- Modal for delete request confirmation --}}
                                                    <x-modal name="confirm-blog-deletion{{$chirp->id}}" :show="$errors->requestDeletion->isNotEmpty()" focusable>
                                                        <form method="post" action="{{ route('chirps.destroy', $chirp) }}" class="p-6">
                                                            @csrf
                                                            @method('delete')

                                                            {{-- Hidden form to send request_id --}}
                                                            @if(!$chirpCount == 0)
                                                                <input type="text" name="chirp_id" value="{{$chirp->id}}" hidden>
                                                            @endif
                                                            <h2 class="text-lg font-medium text-gray-900">
                                                                {{ __('Are you sure you want to delete this blog?') }}
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