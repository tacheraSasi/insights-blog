@props(['insight' => null, 'markdown' => null])

@if($insight)
    @php
        $content = $insight->content_with_toc_ids;
        $showToc = $insight->should_show_toc;
    @endphp

    <div class="prose dark:prose-invert max-w-none">
        @if($showToc)
            {!! $insight->table_of_contents_html !!}
        @endif

        <div class="markdown-content">
            {!! Illuminate\Support\Str::markdown($content) !!}
        </div>
    </div>
@elseif($markdown)
    @php
        $converter = new \League\CommonMark\CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    @endphp

    <div class="prose dark:prose-invert max-w-none">
        <div class="markdown-content">
            {!! $converter->convertToHtml($markdown) !!}
        </div>
    </div>
@endif

<style>
/* Medium.com-inspired typography and layout */
.markdown-content {
    line-height: 1.7;
    font-family: 'Georgia', 'Times New Roman', serif;
}

.markdown-content h1 {
    @apply text-4xl font-bold mb-6 mt-8 text-gray-900 dark:text-white;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.markdown-content h2 {
    @apply text-3xl font-bold mb-5 mt-8 text-gray-900 dark:text-white;
    line-height: 1.3;
    letter-spacing: -0.01em;
}

.markdown-content h3 {
    @apply text-2xl font-semibold mb-4 mt-6 text-gray-900 dark:text-white;
    line-height: 1.4;
}

.markdown-content h4, .markdown-content h5, .markdown-content h6 {
    @apply text-xl font-semibold mb-3 mt-5 text-gray-900 dark:text-white;
    line-height: 1.4;
}

.markdown-content p {
    @apply text-lg mb-6 text-gray-800 dark:text-gray-200;
    line-height: 1.7;
}

.markdown-content blockquote {
    @apply border-l-4 border-green-500 pl-6 ml-0 my-8 italic text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 py-4 rounded-r-lg;
    font-size: 1.1em;
    line-height: 1.6;
}

.markdown-content blockquote p {
    @apply mb-4 last:mb-0;
}

.markdown-content ul, .markdown-content ol {
    @apply mb-6 pl-6;
}

.markdown-content li {
    @apply text-lg mb-2 text-gray-800 dark:text-gray-200;
    line-height: 1.6;
}

.markdown-content a {
    @apply text-green-600 dark:text-green-400 underline hover:text-green-700 dark:hover:text-green-300 transition-colors;
}

.markdown-content strong {
    @apply font-semibold text-gray-900 dark:text-white;
}

.markdown-content em {
    @apply italic;
}

/* Enhanced code blocks with Prism */
.markdown-content pre[class*="language-"] {
    @apply rounded-lg overflow-x-auto my-8 shadow-lg;
    padding: 1.5rem;
    font-size: 0.9em;
    line-height: 1.5;
    background: #1e293b !important;
}

.markdown-content code[class*="language-"] {
    @apply text-sm;
    font-family: 'Fira Code', 'Monaco', 'Cascadia Code', monospace;
}

.markdown-content :not(pre) > code {
    @apply bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-sm font-medium;
    color: #e11d48;
    font-family: 'Fira Code', 'Monaco', 'Cascadia Code', monospace;
}

/* Table styling */
.markdown-content table {
    @apply w-full border-collapse my-8 shadow-sm;
}

.markdown-content th {
    @apply bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-3 text-left font-semibold text-gray-900 dark:text-white;
}

.markdown-content td {
    @apply border border-gray-200 dark:border-gray-700 px-4 py-3 text-gray-800 dark:text-gray-200;
}

/* Image styling */
.markdown-content img {
    @apply rounded-lg shadow-md my-8 max-w-full h-auto;
}

/* Horizontal rule */
.markdown-content hr {
    @apply my-12 border-t-2 border-gray-200 dark:border-gray-700;
}

/* Reading time and TOC styling */
.reading-time {
    @apply text-sm text-gray-600 dark:text-gray-400 mb-4;
}

.table-of-contents {
    @apply bg-gray-50 dark:bg-gray-800 p-6 rounded-lg mb-8 border border-gray-200 dark:border-gray-700;
}

.table-of-contents h3 {
    @apply text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100;
    margin-top: 0 !important;
}

.table-of-contents ul {
    @apply list-none pl-0 mb-0;
}

.table-of-contents li {
    @apply mb-2 text-base;
}

.table-of-contents a {
    @apply text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 no-underline hover:underline transition-colors;
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

/* Remove default prose margins for better control */
.markdown-content .prose * {
    margin-top: 0;
    margin-bottom: 0;
}
</style>
