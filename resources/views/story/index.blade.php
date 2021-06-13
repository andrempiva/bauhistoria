<x-app-layout-v2>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="flex justify-between mb-4">
            <h3 class="font-serif text-4xl text-gray-700 ml-6">
                List of Stories
            </h3>
            <div class="flex items-center">
                <a href="{{ route('story.create') }}"
                    class="px-4 py-2 bg-gray-800 border
                    border-transparent rounded-md font-semibold text-xs text-white
                    uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:border-gray-900 focus:ring ring-gray-300
                    disabled:opacity-25 transition ease-in-out duration-150 ml-2"
                >
                    New Story
                </a>
            </div>
        </div>
        {{-- tabela de stories --}}
        <table class="shadow">
            <thead class="font-semibold">
                <tr class="bg-gray-100">
                    <x-table-td>Cover</x-table-td>
                    <x-table-td>Title</x-table-td>
                    <x-table-td>Author</x-table-td>
                    <x-table-td>Status</x-table-td>
                    <x-table-td>Actions</x-table-td>
                </tr>
            </thead>
            @forelse ($stories as $story)
                <x-story.itemlist :story="$story" :user="$user"/>
            @empty
                <td colspan="5" class="text-center">No stories in the Database</td>
            @endforelse
        </table>
    </x-slot>
</x-app-layout-v2>
