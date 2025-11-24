<x-layouts.app :title="__('Dashboard')">
<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-3xl bg-[#f0f5f4] p-4 dark:bg-neutral-900">

        <!-- Session Messages (Success/Error Notifications) -->
        @if (session('success'))
            <div id="success-message" class="rounded-2xl border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-emerald-800 shadow-sm dark:border-emerald-700/40 dark:bg-emerald-900/30 dark:text-emerald-200" role="alert">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('success-message');
                    if (msg) {
                        msg.classList.add('opacity-0');
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 3000);
            </script>

        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-100 p-4 text-sm text-red-800 dark:bg-red-900 dark:text-red-300" role="alert">
                {{ session('error') }}
            </div>
        @endif

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <section class="relative overflow-hidden rounded-3xl border border-[#6F9F9C]/30 bg-gradient-to-br from-[#6F9F9C] via-[#6F9F9C]/90 to-[#88b8b5] p-8 text-white shadow-xl">
            <div class="relative z-10 flex h-full flex-col justify-between gap-6">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-white/70">YKNIJ Library</p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">
                        Create your collection with confidence.
                    </h1>
                    <p class="mt-3 max-w-xl text-white/75">
                        Track books, explore categories, and keep your catalog fresh with a
                        calm, library-inspired workspace.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="#add-book" class="rounded-2xl bg-white/15 px-5 py-2 text-sm font-medium tracking-wide text-white backdrop-blur transition hover:bg-white/25">
                        Add a New Title
                    </a>
                    <a href="#books-table" class="rounded-2xl border border-white/30 px-5 py-2 text-sm font-medium tracking-wide text-white/90 transition hover:bg-white/15">
                        Browse Collection
                    </a>
                </div>
            </div>
            <span class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/15 blur-3xl"></span>
            <span class="absolute bottom-6 right-4 h-16 w-16 rounded-full border border-white/30"></span>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
            <div class="rounded-2xl border border-white/40 bg-white/80 p-5 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-[#6F9F9C]">Total Books</p>
                <p class="mt-3 text-4xl font-semibold text-neutral-900 dark:text-white">{{ $totalBooks }}</p>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Available across all categories</p>
            </div>

            <div class="rounded-2xl border border-white/40 bg-white/80 p-5 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-[#6F9F9C]">Categories</p>
                <p class="mt-3 text-4xl font-semibold text-neutral-900 dark:text-white">{{ $totalCategories }}</p>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Genres in your archive</p>
            </div>

            <div class="rounded-2xl border border-[#6F9F9C]/30 bg-[#6F9F9C]/10 p-5 shadow-inner dark:border-[#6F9F9C]/40 dark:bg-[#6F9F9C]/15">
                <p class="text-xs font-medium uppercase tracking-widest text-[#6F9F9C]">Latest Arrival</p>
                <p class="mt-3 text-lg font-semibold text-neutral-900 dark:text-white">{{ $latestBook->title ?? 'N/A' }}</p>
                <p class="text-sm text-neutral-600 dark:text-neutral-300">By {{ $latestBook->author ?? 'Unknown' }}</p>
                <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">{{ Str::limit($latestBook->description ?? 'No description available.', 90) }}</p>
            </div>
        </section>
    </div>

    <div id="add-book" class="rounded-3xl border border-white/60 bg-white/90 p-6 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">Catalog</p>
                <h2 class="text-2xl font-semibold text-neutral-900 dark:text-white">Add a New Book</h2>
            </div>
            <span class="rounded-full bg-[#6F9F9C]/15 px-4 py-1 text-xs font-medium text-[#6F9F9C]">Quick Entry</span>
        </div>

        <form action="{{ route('books.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-3">
                <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Title
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. The Night Library" required
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                </label>
                <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Author
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="e.g. Jinky Salvador" required
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                </label>
                <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Category
                    <select name="category_id" required
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label class="block space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                Description
                <textarea name="description" rows="3" placeholder="Enter a short synopsis"
                    class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
            </label>

            <div class="flex items-center justify-end gap-3">
                <button type="reset" class="rounded-2xl border border-neutral-200 px-5 py-2 text-sm font-medium text-neutral-500 transition hover:text-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white">
                    Clear
                </button>
                <button type="submit" class="rounded-2xl bg-[#6F9F9C] px-6 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-[#6F9F9C]/30 transition hover:brightness-105">
                    Add Book
                </button>
            </div>
        </form>
    </div>

    <div id="books-table" class="flex-1 rounded-3xl border border-white/60 bg-white/90 p-6 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">Collection</p>
                <h2 class="text-2xl font-semibold text-neutral-900 dark:text-white">Bookshelf Overview</h2>
            </div>
            <div class="rounded-full bg-[#6F9F9C]/15 px-4 py-1 text-xs font-medium text-[#6F9F9C]">
                {{ $books->count() }} titles
            </div>
        </div>

        <div class="mt-6 overflow-auto rounded-2xl border border-neutral-100 shadow-sm dark:border-neutral-800">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-[#6F9F9C]/10 text-[#2e4c4a] dark:bg-[#6F9F9C]/20 dark:text-white">
                    <tr>
                        <th class="px-4 py-3 font-semibold tracking-wide">#</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Title</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Author</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Category</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Description</th>
                        <th class="px-4 py-3 text-center font-semibold tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 bg-white dark:divide-neutral-800 dark:bg-neutral-900">
                    @forelse($books as $book)
                        <tr class="hover:bg-[#6F9F9C]/5 dark:hover:bg-[#6F9F9C]/20">
                            <td class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-white">{{ $book->title }}</td>
                            <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-200">{{ $book->author }}</td>
                            <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-200">{{ $book->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-300">{{ Str::limit($book->description, 80) }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium">
                                @php
                                    $payload = [
                                        'id' => $book->id,
                                        'title' => $book->title,
                                        'author' => $book->author,
                                        'category_id' => $book->category_id,
                                        'description' => $book->description,
                                    ];
                                @endphp
                                <button type="button"
                                    onclick="openEditBookModal(this)"
                                    data-book='@json($payload)'
                                    class="rounded-full bg-[#6F9F9C]/15 px-3 py-1 text-[#2e4c4a] transition hover:bg-[#6F9F9C]/25 dark:text-white">
                                    Edit
                                </button>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?')" class="mt-2 inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-full px-3 py-1 text-red-500 transition hover:bg-red-50 dark:hover:bg-red-500/10">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                Your shelves are empty. Start by adding a title above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- *EDIT BOOK MODAL START* --}}
<div id="editBookModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-2xl rounded-3xl border border-white/20 bg-white/95 p-6 shadow-2xl backdrop-blur dark:border-neutral-700 dark:bg-neutral-900">
        <h2 class="mb-4 text-2xl font-semibold text-neutral-900 dark:text-white">Edit Book</h2>

        <form id="editBookForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid gap-4 md:grid-cols-3">
                    <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                        Title
                        <input type="text" id="edit_title" name="title" required
                            class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                    </label>

                    <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                        Author
                        <input type="text" id="edit_author" name="author" required
                            class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                    </label>

                    <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                        Category
                        <select id="edit_category_id" name="category_id" required
                            class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <label class="block space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Description
                    <textarea id="edit_description" name="description" rows="3"
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditBookModal()"
                    class="rounded-2xl border border-neutral-200 px-5 py-2 text-sm font-medium text-neutral-500 transition hover:text-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white">
                    Cancel
                </button>
                <button type="submit"
                    class="rounded-2xl bg-[#6F9F9C] px-6 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-[#6F9F9C]/30 transition hover:brightness-105">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>
{{-- *EDIT BOOK MODAL END* --}}

<script>
    function openEditBookModal(trigger) {
        const dataset = trigger?.dataset?.book;
        const book = dataset ? JSON.parse(dataset) : {};
        const modal = document.getElementById('editBookModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        const form = document.getElementById('editBookForm');
        form.action = `/books/${book.id}`;

        document.getElementById('edit_title').value = book.title ?? '';
        document.getElementById('edit_author').value = book.author ?? '';
        document.getElementById('edit_category_id').value = book.category_id ?? '';
        document.getElementById('edit_description').value = book.description ?? '';
    }

    function closeEditBookModal() {
        const modal = document.getElementById('editBookModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
</x-layouts.app>