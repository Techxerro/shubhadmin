<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shubharambh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col justify-between">
            <div class="p-5">
                <h2 class="text-2xl font-bold mb-6">Shubharambh</h2>

                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 0L5 14m7-5l7 5" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Properties Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('properties.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-700">

                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                <span>Properties</span>
                            </div>

                            <svg class="w-4 h-4 transform transition-transform duration-200"
                                 :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition x-cloak class="mt-2 ml-6 space-y-1">
                            <a href="{{ route('properties.create') }}"
                               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('properties.create') ? 'bg-gray-700' : '' }}">
                                Add Property
                            </a>

                            <a href="{{ route('properties.index') }}"
                               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('properties.index') ? 'bg-gray-700' : '' }}">
                                Property List
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- User Info + Logout -->
            <div class="p-5 border-t border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="text-white font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white shadow rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
