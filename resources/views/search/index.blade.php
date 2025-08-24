<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <!-- Search Form -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('search') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Query -->
                    <div>
                        <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                        <input type="text" 
                               id="q" 
                               name="q" 
                               value="{{ $query }}" 
                               placeholder="Search insights..."
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select name="category" 
                                id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ $category == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tag Filter -->
                    <div>
                        <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tag</label>
                        <select name="tag" 
                                id="tag"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Tags</option>
                            @foreach($tags as $tg)
                                <option value="{{ $tg->slug }}" {{ $tag == $tg->slug ? 'selected' : '' }}>
                                    {{ $tg->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                        Search
                    </button>
                    
                    @if($query || $category || $tag)
                        <a href="{{ route('search') }}" 
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                @if($query)
                    Search results for "{{ $query }}" 
                @else
                    All insights
                @endif
                ({{ $insights->total() }} found)
            </h3>
        </div>

        @if($insights->count())
            <!-- Responsive Grid -->
            <div class="grid max-w-2xl grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 lg:max-w-none">
                @foreach($insights as $insight)
                    <x-card>
                        <article class="flex h-[400px] w-full flex-col justify-between bg-white dark:bg-neutral-900 rounded-lg">
                            <!-- Time, Category Badge, and Reading Time -->
                            <div class="flex items-center gap-x-2 text-xs">
                                <time datetime="{{ $insight->created_at }}" class="text-neutral-500 mx-2">
                                    {{ $insight->created_at->diffForHumans() }}
                                </time>
                                <a href="{{ route('search') }}?category={{ $insight->category->slug }}" 
                                   class="relative z-10 rounded-full mx-2 bg-neutral-800 px-2 py-1.5 font-medium text-neutral-400 hover:bg-neutral-700">
                                    {{ $insight->category->name }}
                                </a>
                            </div>
                            
                            <!-- Reading Time -->
                            <div class="mx-2 mt-1">
                                {!! $insight->reading_time_html !!}
                            </div>

                            <!-- Title and Excerpt -->
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-neutral-900 dark:text-neutral-300">
                                    <a href="{{ route('insights.show', $insight->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $insight->title }}
                                    </a>
                                </h3>
                                <div class="mt-3 line-clamp-3 h-[200px] overflow-hidden text-sm leading-6 text-gray-600 dark:text-neutral-400">
                                    {!! Str::limit($insight->content, 200) !!}
                                </div>
                            </div>

                            <!-- Tags -->
                            @if($insight->tags->count())
                                <div class="mx-2 my-2 flex flex-wrap gap-1">
                                    @foreach($insight->tags as $insightTag)
                                        <a href="{{ route('search') }}?tag={{ $insightTag->slug }}"
                                           class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800">
                                            {{ $insightTag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Author Info -->
                            <div class="relative mt-6 flex items-center gap-x-2">
                                <div class="text-sm leading-6">
                                    <p class="font-semibold text-neutral-500">
                                        <a href="/{{ $insight->user->name }}">
                                            <span class="absolute inset-0"></span>
                                            {{ $insight->user->name }}
                                        </a>
                                    </p>
                                    <p class="text-neutral-600">{{ $insight->likes->count() }} Likes</p>
                                </div>
                            </div>
                        </article>
                    </x-card>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="m-4">
                {{ $insights->appends(request()->query())->links() }}
            </div>
        @else
            <x-card>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No insights found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search terms or filters.</p>
                </div>
            </x-card>
        @endif
    </div>
</x-app-layout>