<x-layouts.app :title="__('Dashboard')">
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    @if(session('success'))
        <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
        <div class="flex h-full flex-col p-6">

            <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Book</h2>

                <form action="{{ route('books.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter book title" required
                                   class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" value="{{ old('author') }}" placeholder="Enter author name" required
                                   class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" required
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                        <textarea name="description" rows="2" placeholder="Enter book description"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700">
                            Add Book
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex-1 overflow-auto">
                <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Books List</h2>
                <table class="w-full min-w-full">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                            <th class="px-4 py-3 text-sm text-left font-semibold">#</th>
                            <th class="px-4 py-3 text-sm text-left font-semibold">Title</th>
                            <th class="px-4 py-3 text-sm text-left font-semibold">Author</th>
                            <th class="px-4 py-3 text-sm text-left font-semibold">Category</th>
                            <th class="px-4 py-3 text-sm text-left font-semibold">Description</th>
                            <th class="px-4 py-3 text-sm text-center font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($books as $book)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm">{{ $book->title }}</td>
                                <td class="px-4 py-3 text-sm">{{ $book->author }}</td>
                                <td class="px-4 py-3 text-sm">{{ $book->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ Str::limit($book->description, 60) }}</td>

                                <td class="px-4 py-3 text-center text-sm">
                                    {{-- **EDIT BUTTON START** --}}
                                    <button onclick="editBook({{ $book->id }}, '{{ $book->title }}', '{{ $book->author }}', {{ $book->category_id }}, '{{ $book->description }}')"
                                             class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </button>
                                    <span class="mx-1 text-neutral-400">|</span>
                                    {{-- **EDIT BUTTON END** --}}

                                    <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-neutral-500">
                                    No books found. Add one above!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- **EDIT BOOK MODAL START** --}}
<div id="editBookModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
        <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Book</h2>

        <form id="editBookForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                        <input type="text" id="edit_title" name="title" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                        <input type="text" id="edit_author" name="author" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                        <select id="edit_category_id" name="category_id" required
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                    <textarea id="edit_description" name="description" rows="2"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditBookModal()"
                        class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                    Cancel
                </button>
                <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>
{{-- **EDIT BOOK MODAL END** --}}

<script>
    // **NEW JAVASCRIPT FUNCTIONS**

    function editBook(id, title, author, categoryId, description) {
        // Show the modal
        const modal = document.getElementById('editBookModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Set the form action URL to the update route (e.g., /books/1)
        const form = document.getElementById('editBookForm');
        form.action = `/books/${id}`; // Adjust this route if your book update route is different

        // Populate the form fields
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_author').value = author;
        document.getElementById('edit_category_id').value = categoryId;
        document.getElementById('edit_description').value = description;
    }

    function closeEditBookModal() {
        // Hide the modal
        const modal = document.getElementById('editBookModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
</x-layouts.app>