@extends('layouts.app')

@section('title', 'Schema Architecture | EasyColoc')

@section('content')
    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12 flex flex-col gap-12">
        <!-- Breadcrumbs & Status -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <nav class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">
                <a class="hover:text-white transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <a class="hover:text-white transition-colors" href="{{ route('colocation.show', $colocationId) }}">Unit Portal</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-white">Taxonomy Schema</span>
            </nav>
            @if (!$is_active)
                <div class="px-4 py-1.5 rounded-full border border-red-500/20 bg-red-500/5 text-[8px] font-bold text-red-500 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-red-500 animate-pulse"></span>
                    Unit Integration Severed
                </div>
            @endif
        </div>

        <!-- Hero Section -->
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-12">
            <div class="max-w-3xl space-y-6">
                <h1 class="text-5xl md:text-7xl font-display font-black text-white tracking-tighter leading-none">
                    Schema <span class="text-neutral-500">Taxonomy</span>
                </h1>
                <p class="text-lg text-neutral-400 font-body leading-relaxed max-w-xl">
                    Define the classification framework for your unit ledger. Categorize resource transmissions with precision and semantic clarity.
                </p>
            </div>
            <div class="hidden md:block">
                <button @disabled(!$is_active) onclick="showCreateModal()"
                    class="btn-modern px-10 py-5 flex items-center gap-3 group">
                    <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">add</span>
                    <span>Define New Schema</span>
                </button>
            </div>
        </section>

        <!-- Category Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($categories as $category)
                <div class="group glass modern-border rounded-3xl p-8 relative overflow-hidden flex flex-col min-h-[280px]">
                    <div class="w-14 h-14 rounded-2xl bg-neutral-900 border border-white/5 flex items-center justify-center text-neutral-500 mb-8 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">terminal</span>
                    </div>
                    
                    <div class="flex-1 space-y-3">
                        <h3 class="text-xl font-display font-bold text-white tracking-tight">{{ $category->name }}</h3>
                        <p class="text-xs text-neutral-500 font-body leading-relaxed line-clamp-3 italic">
                            "{{ $category->description ?? 'No definition provided.' }}"
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex items-center justify-between pt-6 border-t border-white/5">
                        <div class="flex gap-4">
                            <button @disabled(!$is_active)
                                onclick="showEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')"
                                class="text-neutral-600 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </button>
                            <button @disabled(!$is_active) onclick="showDeleteModal({{ $category->id }})" 
                                class="text-neutral-600 hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </div>
                        <span class="text-[8px] font-bold text-neutral-700 uppercase tracking-widest">Type: Static Node</span>
                    </div>

                    <!-- Subtle background decoration -->
                    <div class="absolute -bottom-6 -right-6 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                        <span class="material-symbols-outlined text-[100px]">category</span>
                    </div>
                </div>
            @endforeach

            <!-- Create Trigger Node -->
            @if($is_active)
                <button onclick="showCreateModal()"
                    class="group flex flex-col items-center justify-center p-8 rounded-3xl border-2 border-dashed border-neutral-800 hover:border-white/20 transition-all min-h-[280px] bg-transparent">
                    <div class="w-12 h-12 rounded-full border border-neutral-800 flex items-center justify-center text-neutral-600 group-hover:text-white group-hover:border-white/20 transition-all mb-4">
                        <span class="material-symbols-outlined text-2xl">add</span>
                    </div>
                    <span class="text-[10px] font-bold text-neutral-500 uppercase tracking-[0.2em] group-hover:text-white transition-colors">Initialize Schema</span>
                </button>
            @endif
        </div>
    </main>
@endsection

@section('modals')
    @php
        $is_there_add_category_errors = $errors->addCategory->any();
    @endphp
    <!-- Create Modal -->
    <div id="add-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 @if (!$is_there_add_category_errors) hidden @endif">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="{{ route('colocation.category.store', $colocationId) }}" method="POST" class="p-10 space-y-10">
                @csrf
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Define Schema</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Create a new categorization node for the ledger.</p>
                    </div>
                    <button onclick="closeCreateModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Schema Identifier</label>
                        <input name="name" value="{{ old('name') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="Resource Classification" type="text" />
                        @error('name', 'addCategory')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Semantic Definition</label>
                        <textarea name="description"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            placeholder="Primary objective and scope of this classification..." rows="4">{{ old('description') }}</textarea>
                        @error('description', 'addCategory')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeCreateModal()" type="button" class="btn-outline flex-1 py-4">Abort</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Commit Schema</button>
                </div>
            </form>
        </div>
    </div>

    @php
        $is_there_edit_category_errors = $errors->editCategory->any();
    @endphp
    <!-- Edit Modal -->
    <div id="edit-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 @if (!$is_there_edit_category_errors) hidden @endif">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="" method="POST" class="p-10 space-y-10">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Reconfigure Schema</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Adjust categorization parameters for existing node.</p>
                    </div>
                    <button onclick="closeEditModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Schema Identifier</label>
                        <input name="name" value="{{ old('name') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            type="text" />
                        @error('name', 'editCategory')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Semantic Definition</label>
                        <textarea name="description"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description', 'editCategory')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeEditModal()" type="button" class="btn-outline flex-1 py-4">Abort</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <span class="material-symbols-outlined text-4xl">warning</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Deprioritize Schema?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        Excision of this classification node will leave orphaned ledger entries. Historical data remains for audit purposes.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form action="" method="post" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4 bg-red-500 text-white hover:bg-red-600 border-none">Confirm Excision</button>
                    </form>
                    <button onclick="closeDeleteModal()" class="btn-outline w-full py-4">Maintain Schema</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCreateModal() {
            const modal = document.getElementById('add-category-modal');
            modal.classList.remove('hidden');
        }

        function closeCreateModal() {
            const modal = document.getElementById('add-category-modal');
            const form = modal.querySelector('form');
            form.reset();
            modal.classList.add('hidden');
        }

        function showEditModal(id, name, description) {
            const modal = document.getElementById('edit-category-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.category.update', ':id') }}".replace(':id', id);
            form.querySelector('input[name="name"]').value = name;
            form.querySelector('textarea[name="description"]').value = description;
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-category-modal');
            const form = modal.querySelector('form');
            form.reset();
            form.action = "";
            modal.classList.add('hidden');
        }

        function showDeleteModal(id) {
            const modal = document.getElementById('delete-category-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.category.destroy', ':id') }}".replace(':id', id);
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-category-modal');
            const form = modal.querySelector('form');
            form.action = "";
            modal.classList.add('hidden');
        }
    </script>
@endsection
