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

        <!-- Like, Bookmark and Share Section -->
        <div class="mt-6 flex items-center justify-between bg-white dark:bg-neutral-900 p-4 rounded-lg shadow-sm">
            <div class="flex items-center space-x-4">
                <x-like-button :insight="$insight" />

                <!-- NEW: Bookmark button -->
                <x-bookmark-button :insight="$insight" />

                <!-- Analytics Display -->
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    {{ $insight->uniqueViews() }} views
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600 dark:text-gray-400">Share:</span>
                <x-social-share :insight="$insight" />
            </div>
        </div>

        <x-related-insights :insight="$insight" />

            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $insight->comments->count() }} comments
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-10 mx-10">
            <h2 class="text-3xl font-semibold text-neutral-800 dark:text-neutral-200">Comments ({{ $insight->comments->count() }})</h2>

            <!-- Comment List - NOW WITH THREADING SUPPORT -->
            <div class="mt-6 space-y-6">
                @foreach($insight->topLevelComments as $comment)
                    <div class="comment-thread">
                        <!-- Main Comment -->
                        <div class="p-4 rounded-lg bg-neutral-50 dark:bg-neutral-800 shadow-md">
                            <div class="flex items-start gap-3">
                                <img src="{{ $comment->user->getAvatarUrl() }}"
                                     alt="{{ $comment->user->name }}"
                                     class="w-8 h-8 rounded-full">
                                <div class="flex-1">
                                    <pre class="text-neutral-700 dark:text-neutral-300 whitespace-pre-wrap">{{ $comment->comment }}</pre>
                                    <div class="mt-2 flex items-center justify-between">
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                            {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                        @auth
                                            <button
                                                x-data=""
                                                @click="$dispatch('reply-to-comment', { commentId: {{ $comment->id }}, userName: '{{ $comment->user->name }}' })"
                                                class="text-sm text-green-600 dark:text-green-400 hover:underline">
                                                Reply
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Replies -->
                        @if($comment->allReplies->count() > 0)
                            <div class="ml-8 mt-4 space-y-4">
                                @foreach($comment->allReplies as $reply)
                                    <div class="p-3 rounded-lg bg-neutral-100 dark:bg-neutral-700 border-l-2 border-green-500">
                                        <div class="flex items-start gap-3">
                                            <img src="{{ $reply->user->getAvatarUrl() }}"
                                                 alt="{{ $reply->user->name }}"
                                                 class="w-6 h-6 rounded-full">
                                            <div class="flex-1">
                                                <pre class="text-neutral-700 dark:text-neutral-300 whitespace-pre-wrap text-sm">{{ $reply->comment }}</pre>
                                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                                    {{ $reply->user->name }} | {{ $reply->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Add Comment Form - ENHANCED WITH REPLY SUPPORT -->
            @auth
                <div x-data="commentForm()" class="mt-6">
                    <!-- Reply indicator -->
                    <div x-show="replyingTo" class="mb-3 p-2 bg-green-50 dark:bg-green-900 rounded text-sm">
                        <span class="text-green-700 dark:text-green-300">Replying to <strong x-text="replyingToUser"></strong></span>
                        <button @click="cancelReply()" class="ml-2 text-green-600 dark:text-green-400 hover:underline">Cancel</button>
                    </div>

                    <form action="{{ route('comments.store', $insight->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" x-model="parentId">
                        <div>
                            <textarea
                                name="comment"
                                rows="4"
                                class="w-full p-4 rounded-lg border dark:bg-neutral-900 text-black dark:text-white dark:border-neutral-700 focus:outline-none focus:ring focus:ring-neutral-500 dark:focus:ring-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400"
                                :placeholder="replyingTo ? 'Write a reply...' : 'Write a comment...'"
                                required></textarea>
                        </div>
                        <div class="mt-4">
                            <x-primary-button type="submit" class="bg-customGreenDark dark:bg-customGreenLight text-white px-5 py-2 rounded-md border-none hover:bg-neutral-700 dark:hover:bg-neutral-400 transition duration-300">
                                <span x-text="replyingTo ? 'Add Reply' : 'Add Comment'"></span>
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <script>
                function commentForm() {
                    return {
                        replyingTo: null,
                        replyingToUser: '',
                        parentId: null,

                        init() {
                            this.$watch('replyingTo', (value) => {
                                if (value) {
                                    this.$nextTick(() => {
                                        document.querySelector('textarea[name="comment"]').focus();
                                    });
                                }
                            });

                            // Listen for reply events
                            document.addEventListener('reply-to-comment', (e) => {
                                this.replyingTo = e.detail.commentId;
                                this.replyingToUser = e.detail.userName;
                                this.parentId = e.detail.commentId;
                            });
                        },

                        cancelReply() {
                            this.replyingTo = null;
                            this.replyingToUser = '';
                            this.parentId = null;
                        }
                    }
                }
                </script>
            @else
                <p class="text-neutral-600 dark:text-neutral-400 mt-4">You must be logged in to comment.</p>
            @endauth
        </div>
    </div>
</x-app-layout>
