@props(['insight' => null, 'markdown' => null])

@if($insight)
    @php
        $content = $insight->content_with_toc_ids;
        $showToc = $insight->should_show_toc;
        
        // Check if content is markdown (starts with # or contains markdown patterns)
        $isMarkdown = preg_match('/^#|\n#{1,6}\s|```|\*\*|\*[^*]|\[.*\]\(.*\)|\|.*\|/', $content);
        
        if ($isMarkdown) {
            // Create environment with full GitHub Flavored Markdown support
            $environment = new \League\CommonMark\Environment\Environment([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'table' => [
                    'wrap' => [
                        'enabled' => false,
                        'tag' => 'div',
                        'attributes' => [],
                    ],
                ],
            ]);

            // Add extensions for full markdown features
            $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());
            $environment->addExtension(new \League\CommonMark\Extension\GithubFlavoredMarkdownExtension());

            $converter = new \League\CommonMark\MarkdownConverter($environment);
            $renderedContent = $converter->convertToHtml($content);
        } else {
            // Content is already HTML, use Laravel's markdown helper for consistency
            $renderedContent = Illuminate\Support\Str::markdown($content);
        }
    @endphp

    <div class="prose dark:prose-invert max-w-none">
        @if($showToc)
            {!! $insight->table_of_contents_html !!}
        @endif

        <div class="markdown-content">
            {!! $renderedContent !!}
        </div>
    </div>
@elseif($markdown)
    @php
        // Create environment with full GitHub Flavored Markdown support
        $environment = new \League\CommonMark\Environment\Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'table' => [
                'wrap' => [
                    'enabled' => false,
                    'tag' => 'div',
                    'attributes' => [],
                ],
            ],
        ]);

        // Add extensions for full markdown features
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());
        $environment->addExtension(new \League\CommonMark\Extension\GithubFlavoredMarkdownExtension());

        $converter = new \League\CommonMark\MarkdownConverter($environment);
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
    @apply rounded-lg overflow-x-auto my-8 shadow-lg relative;
    padding: 1.5rem;
    font-size: 0.9em;
    line-height: 1.5;
    background: #1e293b !important;
    border: 1px solid #334155;
}

.markdown-content code[class*="language-"] {
    @apply text-sm;
    font-family: 'Fira Code', 'Monaco', 'Cascadia Code', 'SF Mono', 'Consolas', monospace;
    font-weight: 400;
}

/* Inline code styling */
.markdown-content :not(pre) > code {
    @apply bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-sm font-medium;
    color: #e11d48 !important;
    font-family: 'Fira Code', 'Monaco', 'Cascadia Code', 'SF Mono', 'Consolas', monospace;
    font-weight: 600;
    border: 1px solid #e5e7eb;
}

.dark .markdown-content :not(pre) > code {
    border: 1px solid #374151;
    color: #f87171 !important;
}

/* Code block language label */
.markdown-content pre[class*="language-"]:before {
    content: attr(data-language);
    position: absolute;
    top: 0.75rem;
    right: 1rem;
    font-size: 0.75rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.05em;
}

/* Copy button for code blocks */
.markdown-content .code-block-wrapper {
    position: relative;
}

.markdown-content .copy-code-button {
    position: absolute;
    top: 0.75rem;
    right: 1rem;
    background: #334155;
    color: #94a3b8;
    border: 1px solid #475569;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 10;
}

.markdown-content .copy-code-button:hover {
    background: #475569;
    color: #e2e8f0;
    border-color: #64748b;
}

.markdown-content .copy-code-button.copied {
    background: #16a34a;
    color: white;
    border-color: #22c55e;
}

/* Line numbers */
.markdown-content pre[class*="language-"].line-numbers {
    padding-left: 3.8em;
    counter-reset: linenumber;
}

.markdown-content pre[class*="language-"].line-numbers > code {
    position: relative;
    white-space: inherit;
}

.markdown-content .line-numbers .line-numbers-rows {
    position: absolute;
    pointer-events: none;
    top: 1.5rem;
    font-size: 100%;
    left: -3.8em;
    width: 3em;
    letter-spacing: -1px;
    border-right: 1px solid #334155;
    user-select: none;
}

.markdown-content .line-numbers-rows > span {
    pointer-events: none;
    display: block;
    counter-increment: linenumber;
}

.markdown-content .line-numbers-rows > span:before {
    content: counter(linenumber);
    color: #64748b;
    display: block;
    padding-right: 0.8em;
    text-align: right;
}

/* Table styling with enhanced GitHub style */
.markdown-content table {
    @apply w-full border-collapse my-8 shadow-sm;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    overflow: hidden;
}

.dark .markdown-content table {
    border: 1px solid #374151;
}

.markdown-content th {
    @apply bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3 text-left font-semibold text-gray-900 dark:text-white;
    background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
}

.dark .markdown-content th {
    background: linear-gradient(to bottom, #374151, #1f2937);
}

.markdown-content td {
    @apply border-b border-gray-200 dark:border-gray-700 px-4 py-3 text-gray-800 dark:text-gray-200;
}

.markdown-content tbody tr:hover {
    @apply bg-gray-50 dark:bg-gray-800;
}

/* Enhanced strikethrough support */
.markdown-content del {
    @apply line-through text-gray-500 dark:text-gray-400;
    text-decoration-color: #ef4444;
}

/* Task list styling */
.markdown-content input[type="checkbox"] {
    @apply mr-2 w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600;
}

.markdown-content .task-list-item {
    @apply list-none;
}

.markdown-content .task-list-item input {
    @apply mr-2;
}

/* Footnotes styling */
.markdown-content .footnotes {
    @apply mt-12 pt-8 border-t border-gray-200 dark:border-gray-700;
}

.markdown-content .footnotes ol {
    @apply text-sm text-gray-600 dark:text-gray-400;
}

.markdown-content a[href^="#fn"] {
    @apply text-green-600 dark:text-green-400 no-underline;
    font-size: 0.8em;
    vertical-align: super;
}

.markdown-content a[href^="#fnref"] {
    @apply text-green-600 dark:text-green-400 no-underline ml-1;
}

/* Emoji support */
.markdown-content .emoji {
    @apply inline-block w-5 h-5;
}

/* Math expressions (LaTeX) styling */
.markdown-content .math {
    @apply my-4;
}

.markdown-content .math.inline {
    @apply my-0;
}

/* Keyboard key styling */
.markdown-content kbd {
    @apply bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-xs font-mono shadow-sm;
    border-bottom-width: 2px;
    color: #374151;
}

.dark .markdown-content kbd {
    color: #d1d5db;
}

/* Highlight/mark styling */
.markdown-content mark {
    @apply bg-yellow-200 dark:bg-yellow-800 px-1 rounded;
    color: inherit;
}

/* Definition lists */
.markdown-content dl {
    @apply my-6;
}

.markdown-content dt {
    @apply font-semibold text-gray-900 dark:text-white mt-4 first:mt-0;
}

.markdown-content dd {
    @apply ml-6 mt-2 text-gray-700 dark:text-gray-300;
}

/* Abbreviations */
.markdown-content abbr {
    @apply border-b border-dotted border-gray-400 cursor-help;
    text-decoration: none;
}

/* Enhanced GitHub-style alerts/callouts */
.markdown-content .markdown-alert {
    @apply p-4 my-6 border-l-4 rounded-r-lg;
}

.markdown-content .markdown-alert-note {
    @apply border-blue-500 bg-blue-50 dark:bg-blue-900/20;
}

.markdown-content .markdown-alert-tip {
    @apply border-green-500 bg-green-50 dark:bg-green-900/20;
}

.markdown-content .markdown-alert-important {
    @apply border-purple-500 bg-purple-50 dark:bg-purple-900/20;
}

.markdown-content .markdown-alert-warning {
    @apply border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20;
}

.markdown-content .markdown-alert-caution {
    @apply border-red-500 bg-red-50 dark:bg-red-900/20;
}

.markdown-content .markdown-alert-title {
    @apply font-semibold mb-2 flex items-center gap-2;
}

/* Enhanced responsive design for mobile */
@media (max-width: 768px) {
    .markdown-content {
        font-size: 1rem;
    }
    
    .markdown-content h1 {
        @apply text-3xl;
    }
    
    .markdown-content h2 {
        @apply text-2xl;
    }
    
    .markdown-content h3 {
        @apply text-xl;
    }
    
    .markdown-content pre[class*="language-"] {
        font-size: 0.8em;
        padding: 1rem;
    }
    
    .markdown-content .copy-code-button {
        right: 0.5rem;
        top: 0.5rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }
    
    .markdown-content table {
        font-size: 0.9em;
    }
    
    .markdown-content th,
    .markdown-content td {
        @apply px-2 py-2;
    }
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
