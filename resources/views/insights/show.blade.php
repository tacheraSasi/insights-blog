<x-app-layout :insight="$insight">
    {{-- 
    @section('meta_title', $insight->title)
    @section('meta_description', Str::limit($insight->content, 150)) 
    --}}

    <div class="container mx-auto mt-10 p-4">
        <!-- Title and Category Information -->
        <h1 class="font-extrabold text-neutral-900 dark:text-neutral-200 leading-tight text-4xl">{{ $insight->title }}</h1>
        <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
            <span>
                Category: 
                <span class="font-semibold text-neutral-600 dark:text-neutral-300">
                    {{ $insight->category->name }}
                </span>
            </span>
            <span class="text-neutral-300">•</span>
            {!! $insight->reading_time_html !!}
        </div>

        <!-- Insight Content -->
        <x-card>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-x-2 text-xs">
                    <a href="/category/{{ $insight->user->name }}" class="relative z-10 rounded-full mx-2 bg-neutral-800 px-2 py-1.5 font-medium text-neutral-400 hover:bg-neutral-700">
                        {{ $insight->user->name }}
                    </a>
    
                    <time datetime="{{ $insight->created_at }}" class="text-neutral-500 mx-2">
                        {{ $insight->created_at->diffForHumans() }}
                    </time>
                </div>

                <div class="flex items-center gap-x-2">
                    @if (Auth::user() == $insight->user)
                        <x-secondary-link :to="route('insights.edit',$insight->id)">
                            {{__('Edit')}} 
                        </x-secondary-link>
                    @endif
                    <x-primary-button
                        x-data="" 
                        x-on:click.prevent="$dispatch('open-modal', 'share-insight')">
                        {{__('Share')}} 
                    </x-primary-button>
                </div>

                <!-- Share Modal -->
                <x-modal name="share-insight">
                    <div class="p-4">
                        <h1 class="text-2xl font-bold">Share insight</h1>
                        <br>
                        <p>
                            <b>Copy link:</b>  
                            <span id="insight-link">{{ request()->url() }}</span>
                        </p>
                        <div class="mt-6 flex justify-end gap-2">
                            <x-primary-button id="link-copy-button">
                                {{ __('Copy') }}
                            </x-primary-button>
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </div>
                    </div>
                </x-modal>
            </div>

            <article class="max-w-none" id="content-output">
                <!-- Enhanced markdown rendering with TOC -->
                @if($insight->should_show_toc)
                    <div class="table-of-contents bg-gray-50 dark:bg-gray-800 p-6 rounded-lg mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Table of Contents</h3>
                        {!! $insight->table_of_contents_html !!}
                    </div>
                @endif
                
                <div class="prose dark:prose-invert max-w-none markdown-content">
                    {!! Illuminate\Support\Str::markdown($insight->content) !!}
                </div>

                @if (Auth::user() == $insight->user)
                    <div class="flex mt-4">
                        @include("insights.delete-insight")
                    </div>
                @endif
            </article>

            <!-- Tags Section -->
            @if($insight->tags->count())
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Tags:</span>
                    @foreach($insight->tags as $tag)
                        <a href="{{ route('search') }}?tag={{ $tag->slug }}"
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                           style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};"
                        >
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </x-card>

        <!-- Like and Share Section -->
        <div class="mt-6 flex items-center justify-between bg-white dark:bg-neutral-900 p-4 rounded-lg shadow-sm">
            <div class="flex items-center space-x-4">
                <x-like-button :insight="$insight" />
                
                <button
                    x-data="" 
                    x-on:click.prevent="$dispatch('open-modal', 'share-insight')"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition duration-200"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    Share
                </button>
            </div>
            
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $insight->comments->count() }} comments
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-10">
            <h2 class="text-3xl font-semibold text-neutral-800 dark:text-neutral-200">Comments ({{ $insight->comments->count() }})</h2>

            <!-- Comment List -->
            <div class="mt-6 space-y-6">
                @foreach($insight->comments as $comment)
                    <div class="p-4 rounded-lg bg-neutral-50 dark:bg-neutral-800 shadow-md">
                        <pre class="text-neutral-700 dark:text-neutral-300 whitespace-pre-wrap">{{ $comment->comment }}</pre>
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Add Comment Form -->
            @auth
                <form action="{{ route('comments.store', $insight->id) }}" method="POST" class="mt-6">
                    @csrf
                    <div>
                        <textarea name="comment" rows="4" class="w-full p-4 rounded-lg border dark:bg-neutral-900 text-black dark:text-white dark:border-neutral-700 focus:outline-none focus:ring focus:ring-neutral-500 dark:focus:ring-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400" placeholder="Write a comment..." required></textarea>
                    </div>
                    <div class="mt-4">
                        <x-primary-button type="submit" class="bg-customGreenDark dark:bg-customGreenLight text-white px-5 py-2 rounded-md border-none hover:bg-neutral-700 dark:hover:bg-neutral-400 transition duration-300">
                            Add Comment
                        </x-primary-button>
                    </div>
                </form>
            @else
                <p class="text-neutral-600 dark:text-neutral-400 mt-4">You must be logged in to comment.</p>
            @endauth
        </div>
    </div>
</x-app-layout>