<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-neutral-950 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Write a New Insight</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Share your knowledge and insights with the community</p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" id="preview-btn" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-800 hover:bg-gray-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-neutral-900 shadow-xl rounded-lg overflow-hidden">
                <form action="{{ route('insights.store') }}" method="POST" id="insight-form">
                    @csrf
                    
                    <div class="p-6 space-y-6">
                        <!-- Title Section -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" 
                                class="block w-full px-4 py-3 text-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200"
                                placeholder="Enter an engaging title for your insight..."
                                value="{{ old('title') }}" required autofocus>
                            <x-input-error class="mt-1" :messages="$errors->get('title')" />
                        </div>

                        <!-- Auto-generated Slug Preview -->
                        <div class="space-y-2" id="slug-preview-container" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Preview</label>
                            <div class="px-3 py-2 bg-gray-50 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-md">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ url('/insights') }}/</span><span id="slug-preview" class="text-sm font-medium text-blue-600 dark:text-blue-400"></span>
                            </div>
                        </div>

                        <!-- Category Selection -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="block w-full px-4 py-3 border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200">
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1" :messages="$errors->get('category_id')" />
                        </div>

                        <!-- Content Editor Section -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="content" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                    Content <span class="text-red-500">*</span>
                                </label>
                                <div id="editor-stats" class="text-sm text-gray-500 dark:text-gray-400">
                                    0 words • 0 characters
                                </div>
                            </div>
                            <div class="border border-gray-300 dark:border-neutral-600 rounded-lg overflow-hidden">
                                <textarea name="content" id="content" 
                                    class="w-full min-h-96 p-4 border-0 focus:ring-0 resize-none dark:bg-neutral-800 dark:text-white"
                                    placeholder="Start writing your insight here..."
                                    required>{{ old('content') }}</textarea>
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('content')" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Use the rich text editor to format your content. You can add links, images, code blocks, and more.
                            </p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div id="autosave-status" class="text-sm text-gray-500 dark:text-gray-400 hidden">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Autosaved
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="button" id="save-draft" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Save as Draft
                                </button>
                                <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Publish Insight
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preview Modal -->
            <div id="preview-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <div class="inline-block align-bottom bg-white dark:bg-neutral-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white dark:bg-neutral-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Preview</h3>
                                <button type="button" id="close-preview" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div id="preview-content" class="prose dark:prose-invert max-w-none">
                                <!-- Preview content will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JavaScript for enhanced functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const slugPreview = document.getElementById('slug-preview');
            const slugContainer = document.getElementById('slug-preview-container');
            const previewBtn = document.getElementById('preview-btn');
            const previewModal = document.getElementById('preview-modal');
            const closePreview = document.getElementById('close-preview');
            const previewContent = document.getElementById('preview-content');
            const saveDraftBtn = document.getElementById('save-draft');
            const form = document.getElementById('insight-form');

            // Auto-generate slug from title
            titleInput.addEventListener('input', function() {
                const title = this.value;
                if (title.trim()) {
                    const slug = title.toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugPreview.textContent = slug;
                    slugContainer.style.display = slug ? 'block' : 'none';
                } else {
                    slugContainer.style.display = 'none';
                }
            });

            // Preview functionality
            previewBtn.addEventListener('click', function() {
                const title = titleInput.value;
                const content = tinymce.get('content') ? tinymce.get('content').getContent() : '';
                
                if (!title.trim() && !content.trim()) {
                    alert('Please add a title and some content to preview.');
                    return;
                }

                previewContent.innerHTML = `
                    <h1>${title || 'Untitled'}</h1>
                    <div class="mt-6">${content || '<p>No content yet...</p>'}</div>
                `;
                previewModal.classList.remove('hidden');
            });

            // Close preview modal
            closePreview.addEventListener('click', function() {
                previewModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            previewModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Save as draft functionality
            saveDraftBtn.addEventListener('click', function() {
                // For now, just show a notification
                // In a real implementation, this would save to localStorage or send an AJAX request
                const status = document.getElementById('autosave-status');
                status.textContent = 'Draft saved locally';
                status.classList.remove('hidden');
                
                setTimeout(() => {
                    status.classList.add('hidden');
                }, 3000);
            });

            // Sync TinyMCE content before form submission
            form.addEventListener('submit', function(e) {
                if (tinymce.get('content')) {
                    tinymce.get('content').save();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S to save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    saveDraftBtn.click();
                }
                
                // Ctrl/Cmd + P to preview
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    previewBtn.click();
                }
            });
        });
    </script>
</x-app-layout>