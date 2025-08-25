<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-neutral-950 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Insight</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Update your insight content and tags</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('insights.show', $insight->slug) }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-800 hover:bg-gray-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-neutral-900 shadow-xl rounded-lg overflow-hidden">
                <form action="{{ route('insights.update', $insight->id) }}" method="POST" id="insight-form">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Title Section -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                class="block w-full px-4 py-3 text-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors duration-200"
                                placeholder="Enter an engaging title for your insight..."
                                value="{{ old('title', $insight->title) }}" required autofocus>
                            <x-input-error class="mt-1" :messages="$errors->get('title')" />
                        </div>

                        <!-- Category Selection -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="block w-full px-4 py-3 border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors duration-200">
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $insight->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1" :messages="$errors->get('category_id')" />
                        </div>

                        <!-- Tags Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Tags
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">(optional)</span>
                            </label>
                            <div id="tags-container" class="border border-gray-300 dark:border-neutral-600 rounded-lg p-3 min-h-[50px] bg-white dark:bg-neutral-800">
                                <div id="selected-tags" class="flex flex-wrap gap-2 mb-2">
                                    <!-- Pre-populate with existing tags -->
                                    @foreach($insight->tags as $tag)
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-green-500 hover:bg-green-600 transition-colors duration-200">
                                            <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $tag->color }}"></span>
                                            {{ $tag->name }}
                                            <button type="button" class="ml-2 text-white hover:text-gray-200" onclick="removeTag('{{ $tag->id }}')">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="text" id="tag-input" 
                                    class="border-0 outline-none bg-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 w-full" 
                                    placeholder="Type to search and add tags...">
                            </div>
                            
                            <!-- Tag suggestions dropdown -->
                            <div id="tag-suggestions" class="hidden absolute z-10 w-full bg-white dark:bg-neutral-800 border border-gray-300 dark:border-neutral-600 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                            
                            <!-- Hidden inputs for selected tags -->
                            <div id="hidden-tag-inputs">
                                <!-- Pre-populate hidden inputs for existing tags -->
                                @foreach($insight->tags as $tag)
                                    <input type="hidden" name="tags[]" value="{{ $tag->id }}" id="tag-input-{{ $tag->id }}">
                                @endforeach
                            </div>
                            
                            <!-- Available tags display -->
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Available tags:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                        <button type="button" 
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border-2 border-gray-200 dark:border-neutral-600 text-gray-700 dark:text-gray-300 hover:border-green-500 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-200 tag-suggestion {{ $insight->tags->contains($tag->id) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            data-tag-id="{{ $tag->id }}" 
                                            data-tag-name="{{ $tag->name }}"
                                            data-tag-color="{{ $tag->color }}">
                                            <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $tag->color }}"></span>
                                            {{ $tag->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('tags')" />
                        </div>

                        <!-- Content Editor Section -->
                        <div class="space-y-2">
                            <label for="content" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 dark:border-neutral-600 rounded-lg overflow-hidden">
                                <textarea name="content" id="content"
                                    class="w-full min-h-96 p-4 border-0 focus:ring-0 resize-none dark:bg-neutral-800 dark:text-white"
                                    placeholder="Start writing your insight here..."
                                    required>{{ old('content', $insight->content) }}</textarea>
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('content')" />
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('insights.show', $insight->slug) }}" 
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    Cancel
                                </a>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Insight
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom JavaScript for tag functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('tag-input');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const hiddenTagInputsContainer = document.getElementById('hidden-tag-inputs');
            const tagSuggestions = document.getElementById('tag-suggestions');
            const tagSuggestionButtons = document.querySelectorAll('.tag-suggestion');
            
            // Initialize selected tags from existing data
            let selectedTags = [];
            @foreach($insight->tags as $tag)
                selectedTags.push({
                    id: '{{ $tag->id }}',
                    name: '{{ $tag->name }}',
                    color: '{{ $tag->color }}'
                });
            @endforeach

            // Tag selection functionality
            function addTag(tagId, tagName, tagColor) {
                // Check if tag is already selected
                if (selectedTags.find(tag => tag.id === tagId)) {
                    return;
                }

                // Add to selected tags array
                const tag = { id: tagId, name: tagName, color: tagColor };
                selectedTags.push(tag);

                // Create visual tag chip
                const tagChip = document.createElement('div');
                tagChip.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-green-500 hover:bg-green-600 transition-colors duration-200';
                tagChip.innerHTML = `
                    <span class="w-2 h-2 rounded-full mr-2" style="background-color: ${tagColor}"></span>
                    ${tagName}
                    <button type="button" class="ml-2 text-white hover:text-gray-200" onclick="removeTag('${tagId}')">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                `;
                selectedTagsContainer.appendChild(tagChip);

                // Create hidden input for form submission
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'tags[]';
                hiddenInput.value = tagId;
                hiddenInput.id = `tag-input-${tagId}`;
                hiddenTagInputsContainer.appendChild(hiddenInput);

                // Update suggestion buttons
                updateTagSuggestionButtons();
                
                // Clear input
                tagInput.value = '';
            }

            // Global function to remove tags
            window.removeTag = function(tagId) {
                // Remove from selected tags array
                selectedTags = selectedTags.filter(tag => tag.id !== tagId);

                // Remove visual chip
                const tagChips = selectedTagsContainer.children;
                for (let i = 0; i < tagChips.length; i++) {
                    if (tagChips[i].querySelector('button').getAttribute('onclick').includes(tagId)) {
                        tagChips[i].remove();
                        break;
                    }
                }

                // Remove hidden input
                const hiddenInput = document.getElementById(`tag-input-${tagId}`);
                if (hiddenInput) {
                    hiddenInput.remove();
                }

                // Update suggestion buttons
                updateTagSuggestionButtons();
            };

            function updateTagSuggestionButtons() {
                tagSuggestionButtons.forEach(button => {
                    const tagId = button.getAttribute('data-tag-id');
                    const isSelected = selectedTags.find(tag => tag.id === tagId);
                    
                    if (isSelected) {
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        button.classList.remove('hover:border-green-500', 'hover:text-green-600');
                    } else {
                        button.classList.remove('opacity-50', 'cursor-not-allowed');
                        button.classList.add('hover:border-green-500', 'hover:text-green-600');
                    }
                });
            }

            // Add click handlers for tag suggestion buttons
            tagSuggestionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tagId = this.getAttribute('data-tag-id');
                    const tagName = this.getAttribute('data-tag-name');
                    const tagColor = this.getAttribute('data-tag-color');
                    
                    if (!selectedTags.find(tag => tag.id === tagId)) {
                        addTag(tagId, tagName, tagColor);
                    }
                });
            });

            // Initialize button states
            updateTagSuggestionButtons();

            // Handle tag input for searching (same as write form)
            tagInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                
                if (query.length === 0) {
                    tagSuggestions.classList.add('hidden');
                    return;
                }

                const availableTags = Array.from(tagSuggestionButtons)
                    .filter(button => {
                        const tagName = button.getAttribute('data-tag-name').toLowerCase();
                        const tagId = button.getAttribute('data-tag-id');
                        return tagName.includes(query) && !selectedTags.find(tag => tag.id === tagId);
                    })
                    .slice(0, 5);

                if (availableTags.length > 0) {
                    tagSuggestions.innerHTML = availableTags.map(button => {
                        const tagId = button.getAttribute('data-tag-id');
                        const tagName = button.getAttribute('data-tag-name');
                        const tagColor = button.getAttribute('data-tag-color');
                        
                        return `
                            <div class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-neutral-700 flex items-center suggestion-item" 
                                 data-tag-id="${tagId}" data-tag-name="${tagName}" data-tag-color="${tagColor}">
                                <span class="w-2 h-2 rounded-full mr-2" style="background-color: ${tagColor}"></span>
                                ${tagName}
                            </div>
                        `;
                    }).join('');
                    
                    tagSuggestions.querySelectorAll('.suggestion-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const tagId = this.getAttribute('data-tag-id');
                            const tagName = this.getAttribute('data-tag-name');
                            const tagColor = this.getAttribute('data-tag-color');
                            
                            addTag(tagId, tagName, tagColor);
                            tagSuggestions.classList.add('hidden');
                        });
                    });
                    
                    tagSuggestions.classList.remove('hidden');
                } else {
                    tagSuggestions.classList.add('hidden');
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#tags-container') && !e.target.closest('#tag-suggestions')) {
                    tagSuggestions.classList.add('hidden');
                }
            });

            // Handle Enter key in tag input
            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const firstSuggestion = tagSuggestions.querySelector('.suggestion-item');
                    if (firstSuggestion) {
                        firstSuggestion.click();
                    }
                }
            });
        });
    </script>
</x-app-layout>