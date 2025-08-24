@props(['insight' => null, 'markdown' => null])

@php
    $content = $insight ? $insight->content_with_toc_ids : $markdown;
    $showToc = $insight ? $insight->should_show_toc : false;
@endphp

<div class="prose dark:prose-invert max-w-none">
    @if($showToc && $insight)
        {!! $insight->table_of_contents_html !!}
    @endif
    
    <div class="markdown-content">
        @if($insight)
            {!! Illuminate\Support\Str::markdown($content) !!}
        @else
            @php
                $converter = new \League\CommonMark\CommonMarkConverter([
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                ]);
            @endphp
            {!! $converter->convertToHtml($markdown) !!}
        @endif
    </div>
</div>

<style>
/* Custom styles for code blocks with Prism */
.markdown-content pre[class*="language-"] {
    @apply rounded-lg overflow-x-auto;
    margin: 1rem 0;
    padding: 1rem;
}

.markdown-content code[class*="language-"] {
    @apply text-sm;
}

.markdown-content :not(pre) > code {
    @apply bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded text-sm;
    color: inherit;
}

/* Reading time and TOC styling */
.reading-time {
    @apply text-sm text-gray-600 dark:text-gray-400 mb-4;
}

.table-of-contents {
    @apply bg-gray-50 dark:bg-gray-800 p-4 rounded-lg mb-6;
}

.table-of-contents ul {
    @apply list-none pl-0;
}

.table-of-contents li {
    @apply mb-1;
}

.table-of-contents a {
    @apply text-blue-600 dark:text-blue-400 hover:underline;
}

/* Smooth scrolling for TOC links */
html {
    scroll-behavior: smooth;
}

/* Header anchor styling */
.markdown-content h1[id], 
.markdown-content h2[id], 
.markdown-content h3[id], 
.markdown-content h4[id], 
.markdown-content h5[id], 
.markdown-content h6[id] {
    scroll-margin-top: 2rem;
}
</style>
