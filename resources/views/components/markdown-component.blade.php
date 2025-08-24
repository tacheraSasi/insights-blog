<div class="prose dark:prose-invert max-w-none">
    <div class="markdown-content">
        {!! $this->parsedMarkdown() !!}
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
</style>
