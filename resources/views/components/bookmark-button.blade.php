@props(['insight', 'showText' => true])

@auth
    <button 
        x-data="bookmarkButton({{ $insight->id }}, {{ $insight->isBookmarkedBy() ? 'true' : 'false' }}, {{ $insight->bookmarks()->count() }})"
        @click="toggleBookmark()"
        :disabled="loading"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg transition duration-200 group"
        :class="isBookmarked ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'"
    >
        <!-- Bookmark Icon -->
        <svg 
            class="w-5 h-5 transition-transform duration-200"
            :class="isBookmarked ? 'text-yellow-500 scale-110' : 'text-gray-400 group-hover:scale-105'"
            fill="currentColor" 
            viewBox="0 0 24 24"
        >
            <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
        </svg>
        <span class="text-sm font-medium" x-text="bookmarksCount"></span>
        @if($showText)
            <span class="text-sm">Bookmarks</span>
        @endif
    </button>

    <script>
        function bookmarkButton(insightId, initialIsBookmarked, initialBookmarksCount) {
            return {
                isBookmarked: initialIsBookmarked,
                bookmarksCount: initialBookmarksCount,
                loading: false,
                
                async toggleBookmark() {
                    if (this.loading) return;
                    
                    this.loading = true;
                    
                    try {
                        const response = await fetch(`/insights/${insightId}/bookmark`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.isBookmarked = data.isBookmarked;
                            this.bookmarksCount = data.bookmarksCount;
                        } else {
                            console.error('Failed to toggle bookmark');
                        }
                    } catch (error) {
                        console.error('Error toggling bookmark:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
@endauth