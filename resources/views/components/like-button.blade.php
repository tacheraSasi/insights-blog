@props(['insight', 'showText' => true])

@auth
    <button 
        x-data="likeButton({{ $insight->id }}, {{ $insight->isLikedBy() ? 'true' : 'false' }}, {{ $insight->likes()->count() }})"
        @click="toggleLike()"
        :disabled="loading"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg transition duration-200 group"
        :class="isLiked ? 'bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'"
    >
        <!-- Heart Icon -->
        <svg 
            class="w-5 h-5 transition-transform duration-200"
            :class="isLiked ? 'text-red-500 scale-110' : 'text-gray-400 group-hover:scale-105'"
            fill="currentColor" 
            viewBox="0 0 24 24"
        >
            <path x-show="isLiked" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            <path x-show="!isLiked" d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/>
        </svg>
        
        @if($showText)
            <span x-text="isLiked ? 'Liked' : 'Like'" class="text-sm font-medium"></span>
        @endif
        
        <span x-text="likesCount" class="text-sm font-medium"></span>
        
        <!-- Loading Spinner -->
        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>

    <script>
        function likeButton(insightId, initialIsLiked, initialLikesCount) {
            return {
                isLiked: initialIsLiked,
                likesCount: initialLikesCount,
                loading: false,
                
                async toggleLike() {
                    if (this.loading) return;
                    
                    this.loading = true;
                    
                    try {
                        const response = await fetch(`/insights/${insightId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.isLiked = data.isLiked;
                            this.likesCount = data.likesCount;
                        } else {
                            console.error('Failed to toggle like');
                        }
                    } catch (error) {
                        console.error('Error toggling like:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
@else
    <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/>
        </svg>
        <span class="text-sm font-medium">{{ $insight->likes()->count() }}</span>
        @if($showText)
            <span class="text-sm">Likes</span>
        @endif
    </div>
@endauth