<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @php
        $propertyOpen = request()->routeIs('admin.properties.*');
        $developerOpen = request()->routeIs('admin.developers.*');
    @endphp

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold">Admin Panel</h2>
                <div class="mt-4">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-300">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-800' }}">
                    Dashboard
                </a>

                <!-- Properties -->
                <div x-data="{ open: {{ $propertyOpen ? 'true' : 'false' }} }" class="space-y-1">
                    <button
                        @click="open = !open"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left transition {{ $propertyOpen ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-800' }}"
                    >
                        <span>Properties</span>
                        <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 space-y-1">
                        <a href="{{ route('admin.properties.add') }}"
                           class="block rounded-lg px-4 py-2 text-sm transition {{ request()->routeIs('admin.properties.add') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            Add Property
                        </a>

                        <a href="{{ route('admin.properties.list') }}"
                           class="block rounded-lg px-4 py-2 text-sm transition {{ request()->routeIs('admin.properties.list') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            Property List
                        </a>
                    </div>
                </div>

                <!-- Developers -->
                <div x-data="{ open: {{ $developerOpen ? 'true' : 'false' }} }" class="space-y-1">
                    <button
                        @click="open = !open"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left transition {{ $developerOpen ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-800' }}"
                    >
                        <span>Developers</span>
                        <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 space-y-1">
                        <a href="{{ route('admin.developers.add') }}"
                           class="block rounded-lg px-4 py-2 text-sm transition {{ request()->routeIs('admin.developers.add') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            Add Developer
                        </a>

                        <a href="{{ route('admin.developers.list') }}"
                           class="block rounded-lg px-4 py-2 text-sm transition {{ request()->routeIs('admin.developers.list') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            Developer List
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
