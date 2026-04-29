@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Developer List</h1>
            <p class="text-sm text-gray-500">Manage all developers here.</p>
        </div>

        <a href="{{ route('admin.developers.add') }}"
           class="rounded-xl bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">
            Add Developer
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Image</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($developers as $key => $developer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $developers->firstItem() + $key }}</td>

                            <td class="px-4 py-3">
                                @if($developer->image)
                                    <img src="{{ asset($developer->image) }}"
                                         class="h-12 w-12 rounded-lg object-cover border">
                                @else
                                    <span class="text-sm text-gray-400">N/A</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $developer->name }}</td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ \Illuminate\Support\Str::limit($developer->description, 70) }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.developers.edit', $developer->id) }}"
                                       class="rounded-lg bg-yellow-400 px-3 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.developers.delete', $developer->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this developer?')">
                                        @csrf
                                        <button type="submit"
                                                class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                No developers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-4 py-4">
            {{ $developers->links() }}
        </div>
    </div>
</div>
@endsection
