<x-layouts.app :title="__('Categories')">
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

    <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="relative overflow-hidden rounded-3xl border border-[#6F9F9C]/40 bg-white/95 px-8 py-10 shadow-xl backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
            <div class="relative z-10 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">Stacks & Genres</p>
                <h1 class="mt-4 text-3xl font-semibold text-neutral-900 dark:text-white">Curate your categories</h1>
                <p class="mt-3 text-sm text-neutral-600 dark:text-neutral-300">
                    Organize your collection with thoughtful genres, curated tags, and descriptions
                    that guide readers through the shelves.
                </p>
                <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">
                    <span class="rounded-full bg-[#6F9F9C]/10 px-4 py-1">Library theme</span>
                    <span class="rounded-full border border-[#6F9F9C]/30 px-4 py-1">Calm workflow</span>
                </div>
            </div>
            <span class="absolute right-12 top-8 h-20 w-20 rounded-full border border-[#6F9F9C]/30"></span>
            <span class="absolute -bottom-6 -left-10 h-32 w-32 rounded-full bg-[#6F9F9C]/10 blur-3xl"></span>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
            <div class="rounded-2xl border border-white/60 bg-white/90 p-5 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-[#6F9F9C]">Total Categories</p>
                <p class="mt-3 text-4xl font-semibold text-neutral-900 dark:text-white">{{ $categories->count() }}</p>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Active taxonomy entries</p>
            </div>
            <div class="rounded-2xl border border-white/60 bg-white/90 p-5 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-[#6F9F9C]">Featured Genre</p>
                <p class="mt-3 text-lg font-semibold text-neutral-900 dark:text-white">{{ $categories->first()->name ?? '—' }}</p>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ Str::limit($categories->first()->description ?? 'Add your first category to highlight it here.', 80) }}</p>
            </div>
            <div class="rounded-2xl border border-[#6F9F9C]/30 bg-[#6F9F9C]/10 p-5 shadow-inner dark:border-[#6F9F9C]/40 dark:bg-[#6F9F9C]/15">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-[#6F9F9C]">Tip</p>
                <p class="mt-2 text-sm text-neutral-700 dark:text-neutral-200">
                    Pair categories with descriptive summaries so patrons instantly know what they’ll discover.
                </p>
            </div>
        </div>
    </section>

    <section id="add-category" class="rounded-3xl border border-white/60 bg-white/90 p-6 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">New Shelf</p>
                <h2 class="text-2xl font-semibold text-neutral-900 dark:text-white">Add a Category</h2>
            </div>
            <span class="rounded-full bg-[#6F9F9C]/15 px-4 py-1 text-xs font-medium text-[#6F9F9C]">Curator tools</span>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-3">
                <label class="space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Category Name
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Magical Realism" required
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                    @error('name')
                        <p class="text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </label>

                <label class="md:col-span-2 space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Description
                    <textarea name="description" rows="2" placeholder="Describe what makes this category unique"
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="reset" class="rounded-2xl border border-neutral-200 px-5 py-2 text-sm font-medium text-neutral-500 transition hover:text-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white">
                    Clear
                </button>
                <button type="submit" class="rounded-2xl bg-[#6F9F9C] px-6 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-[#6F9F9C]/30 transition hover:brightness-105">
                    Add Category
                </button>
            </div>
        </form>
    </section>

    <section class="flex-1 rounded-3xl border border-white/60 bg-white/90 p-6 shadow-sm backdrop-blur dark:border-neutral-800 dark:bg-neutral-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6F9F9C]">Catalog Taxonomy</p>
                <h2 class="text-2xl font-semibold text-neutral-900 dark:text-white">Categories List</h2>
            </div>
            <div class="rounded-full bg-[#6F9F9C]/15 px-4 py-1 text-xs font-medium text-[#6F9F9C]">{{ $categories->count() }} entries</div>
        </div>

        <div class="mt-6 overflow-auto rounded-2xl border border-neutral-100 shadow-sm dark:border-neutral-800">
            <table class="w-full min-w-[620px] text-left text-sm">
                <thead class="bg-[#6F9F9C]/10 text-[#2e4c4a] dark:bg-[#6F9F9C]/20 dark:text-white">
                    <tr>
                        <th class="px-4 py-3 font-semibold tracking-wide">#</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Name</th>
                        <th class="px-4 py-3 font-semibold tracking-wide">Description</th>
                        <th class="px-4 py-3 text-center font-semibold tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 bg-white dark:divide-neutral-800 dark:bg-neutral-900">
                    @forelse($categories as $category)
                        @php
                            $categoryPayload = [
                                'id' => $category->id,
                                'name' => $category->name,
                                'description' => $category->description,
                            ];
                        @endphp
                        <tr class="hover:bg-[#6F9F9C]/5 dark:hover:bg-[#6F9F9C]/20">
                            <td class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-white">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-300">{{ Str::limit($category->description, 70) ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium">
                                <button type="button"
                                    data-category='@json($categoryPayload)'
                                    onclick="openEditCategoryModal(this)"
                                    class="rounded-full bg-[#6F9F9C]/15 px-3 py-1 text-[#2e4c4a] transition hover:bg-[#6F9F9C]/25 dark:text-white">
                                    Edit
                                </button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="mt-2 inline-block" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full px-3 py-1 text-red-500 transition hover:bg-red-50 dark:hover:bg-red-500/10">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-neutral-500 dark:text-neutral-400">No categories found. Add one above.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

{{-- **EDIT CATEGORY MODAL START** --}}
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-2xl rounded-3xl border border-white/20 bg-white/95 p-6 shadow-2xl backdrop-blur dark:border-neutral-700 dark:bg-neutral-900">
        <h2 class="mb-4 text-2xl font-semibold text-neutral-900 dark:text-white">Edit Category</h2>

        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <label class="block space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Category Name
                    <input type="text" id="edit_name" name="name" required
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                </label>
                <label class="block space-y-2 text-sm font-medium text-neutral-600 dark:text-neutral-200">
                    Description
                    <textarea id="edit_description" name="description" rows="3"
                        class="w-full rounded-2xl border border-neutral-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-[#6F9F9C] focus:ring-2 focus:ring-[#6F9F9C]/30 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditCategoryModal()"
                    class="rounded-2xl border border-neutral-200 px-5 py-2 text-sm font-medium text-neutral-500 transition hover:text-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white">
                    Cancel
                </button>
                <button type="submit"
                    class="rounded-2xl bg-[#6F9F9C] px-6 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-[#6F9F9C]/30 transition hover:brightness-105">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
{{-- **EDIT CATEGORY MODAL END** --}}

<script>
    function openEditCategoryModal(trigger) {
        const payload = trigger?.dataset?.category ? JSON.parse(trigger.dataset.category) : {};
        const modal = document.getElementById('editCategoryModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        const form = document.getElementById('editCategoryForm');
        form.action = `/categories/${payload.id}`;

        document.getElementById('edit_name').value = payload.name ?? '';
        document.getElementById('edit_description').value = payload.description ?? '';
    }

    function closeEditCategoryModal() {
        const modal = document.getElementById('editCategoryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
</x-layouts.app>