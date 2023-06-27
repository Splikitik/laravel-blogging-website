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
<div class="bg-white">
    <x-app-layout>
        <x-slot name="header">
            <a href="../../admin.dashboard">
                <h2 class="bg-white hover:bg-sky-50 p-4 rounded-lg font-semibold text-xl text-gray-800 leading-tight">
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
                                {{ __('Website Statistics') }}
                            </h2>
                        </div>
                        <div>
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                                <div class="max-w-xl">
                                    <p>Pending Requests: {{ $pendingCount }}</p>
                                    <x-hyperlink-button href="admin/dashboard/requests">View</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                                <div class="max-w-xl">
                                    <p>Number of Users: {{ $userCount }}</p>
                                    <x-hyperlink-button href="admin/dashboard/users">View</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:hidden">
                                <div class="max-w-xl">
                                    <p>Number of Blogs: {{ $chirpCount }}</p>
                                    <x-hyperlink-button href="admin/dashboard/blogs">View</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="flex -mx-2 max-sm:hidden">
                                <div class="w-1/3 px-2">
                                    <div class="flex font-bold text-xl rounded-lg bg-emerald-400 h-20 p-5 justify-between items-center border border-black">
                                        
                                        <p>Pending Requests: {{ $pendingCount }}</p>
                                        <x-hyperlink-button href="admin/dashboard/requests">View</x-hyperlink-button>
                                    </div>
                                </div>
                            <div class="w-1/3 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-lime-400 h-20 p-5 justify-between items-center border border-black">
                                    <p>Number of Users: {{ $userCount }}</p>
                                    <x-hyperlink-button href="admin/dashboard/users">View</x-hyperlink-button>
                                </div>
                            </div>
                            <div class="w-1/3 px-2">
                                <div class="flex font-bold text-xl rounded-lg bg-teal-400 h-20 p-5 justify-between items-center border border-black">
                                    <p>Number of Blogs: {{ $chirpCount }}</p>
                                    <x-hyperlink-button href="admin/dashboard/blogs">View</x-hyperlink-button>
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