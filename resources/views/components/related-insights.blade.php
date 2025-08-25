@props(['insight'])

@php
    $relatedInsights = $insight->getRelatedInsights(3);
@endphp

@if($relatedInsights->count() > 0)
<div class="mt-12 bg-white dark:bg-neutral-900 rounded-lg shadow-sm p-6">
    <h3 class="text-xl font-semibold text-neutral-800 dark:text-neutral-200 mb-6">
        Related Insights
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($relatedInsights as $related)
            <article class="group">
                <a href="{{ route('insights.show', $related->slug) }}" 
                   class="block bg-neutral-50 dark:bg-neutral-800 rounded-lg p-4 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition duration-200">
                    
                    <h4 class="font-medium text-neutral-800 dark:text-neutral-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition duration-200 line-clamp-2 mb-2">
                        {{ $related->title }}
                    </h4>
                    
                    <div class="flex items-center justify-between text-sm text-neutral-600 dark:text-neutral-400">
                        <span>{{ $related->user->name }}</span>
                        <span>{{ $related->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 mt-3 text-xs text-neutral-500 dark:text-neutral-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            {{ $related->likes->count() }}
                        </span>
                        
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                            </svg>
                            {{ $related->uniqueViews() }}
                        </span>
                    </div>
                    
                    @if($related->tags->count() > 0)
                        <div class="flex flex-wrap gap-1 mt-2">
                            @foreach($related->tags->take(2) as $tag)
                                <span class="inline-block px-2 py-1 text-xs rounded text-white" 
                                      style="background-color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                            @if($related->tags->count() > 2)
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                    +{{ $related->tags->count() - 2 }} more
                                </span>
                            @endif
                        </div>
                    @endif
                </a>
            </article>
        @endforeach
    </div>
</div>
@endif