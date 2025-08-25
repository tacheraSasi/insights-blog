@props(['name' => 'content', 'value' => '', 'id' => 'markdown-editor'])

<div class="markdown-editor-container">
    <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
            <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Content
            </label>
            <div class="flex items-center space-x-2">
                <button 
                    type="button" 
                    id="preview-toggle-{{ $id }}"
                    class="text-sm px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                >
                    Preview
                </button>
                <button 
                    type="button" 
                    id="fullscreen-toggle-{{ $id }}"
                    class="text-sm px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                >
                    Fullscreen
                </button>
            </div>
        </div>
        
        <div class="relative">
            <!-- Editor Toolbar -->
            <div id="toolbar-{{ $id }}" class="border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 p-2 rounded-t-lg">
                <div class="flex flex-wrap gap-1">
                    <button type="button" class="toolbar-btn" data-action="bold" title="Bold (Ctrl+B)">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3H6a1 1 0 000 2h1v10H6a1 1 0 000 2h5a4 4 0 001.866-7.539A3.5 3.5 0 0011 3zm-1 4V5h1a1.5 1.5 0 010 3h-1zm0 2h1.5a2 2 0 010 4H10V9z"/>
                        </svg>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="italic" title="Italic (Ctrl+I)">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 3a1 1 0 000 2h1.5l-1.333 8H7a1 1 0 100 2h4a1 1 0 000-2h-1.5L10.833 5H12a1 1 0 000-2H8z"/>
                        </svg>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="heading" title="Heading">
                        <span class="font-bold text-sm">H</span>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="code" title="Code">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="link" title="Link">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"/>
                        </svg>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="list" title="List">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                        </svg>
                    </button>
                    <button type="button" class="toolbar-btn" data-action="quote" title="Quote">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0-4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0-4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Editor Tabs -->
            <div class="flex border-b border-gray-200 dark:border-gray-600">
                <button 
                    type="button" 
                    id="write-tab-{{ $id }}" 
                    class="tab-btn active px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border-b-2 border-blue-500"
                >
                    Write
                </button>
                <button 
                    type="button" 
                    id="preview-tab-{{ $id }}" 
                    class="tab-btn px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border-b-2 border-transparent hover:text-gray-700 dark:hover:text-gray-300"
                >
                    Preview
                </button>
            </div>
            
            <!-- Write Panel -->
            <div id="write-panel-{{ $id }}" class="tab-panel">
                <textarea 
                    id="{{ $id }}"
                    name="{{ $name }}"
                    rows="20"
                    class="w-full p-4 border-0 rounded-b-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-0 resize-none font-mono text-sm"
                    placeholder="Write your content in Markdown..."
                >{{ $value }}</textarea>
            </div>
            
            <!-- Preview Panel -->
            <div id="preview-panel-{{ $id }}" class="tab-panel hidden p-4 min-h-[500px] bg-white dark:bg-gray-900 rounded-b-lg prose dark:prose-invert max-w-none">
                <div id="preview-content-{{ $id }}" class="markdown-content">
                    <!-- Preview content will be rendered here -->
                </div>
            </div>
        </div>
        
        <!-- Helper Text -->
        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            <span>Supports Markdown formatting. </span>
            <a href="https://www.markdownguide.org/basic-syntax/" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                View Markdown Guide
            </a>
        </div>
    </div>
</div>

<style>
.toolbar-btn {
    @apply p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 rounded transition-colors;
}

.tab-btn.active {
    @apply text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-900 border-blue-500;
}

.markdown-editor-container.fullscreen {
    @apply fixed inset-0 z-50 bg-white dark:bg-gray-900 p-4;
}

.markdown-editor-container.fullscreen textarea {
    @apply h-full;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editorId = '{{ $id }}';
    const textarea = document.getElementById(editorId);
    const writeTab = document.getElementById(`write-tab-${editorId}`);
    const previewTab = document.getElementById(`preview-tab-${editorId}`);
    const writePanel = document.getElementById(`write-panel-${editorId}`);
    const previewPanel = document.getElementById(`preview-panel-${editorId}`);
    const previewContent = document.getElementById(`preview-content-${editorId}`);
    const fullscreenToggle = document.getElementById(`fullscreen-toggle-${editorId}`);
    const container = textarea.closest('.markdown-editor-container');
    
    // Tab switching
    writeTab.addEventListener('click', () => switchTab('write'));
    previewTab.addEventListener('click', () => switchTab('preview'));
    
    function switchTab(tab) {
        if (tab === 'write') {
            writeTab.classList.add('active', 'text-blue-600', 'dark:text-blue-400', 'bg-white', 'dark:bg-gray-900', 'border-blue-500');
            writeTab.classList.remove('text-gray-500', 'dark:text-gray-400', 'bg-gray-50', 'dark:bg-gray-800', 'border-transparent');
            previewTab.classList.remove('active', 'text-blue-600', 'dark:text-blue-400', 'bg-white', 'dark:bg-gray-900', 'border-blue-500');
            previewTab.classList.add('text-gray-500', 'dark:text-gray-400', 'bg-gray-50', 'dark:bg-gray-800', 'border-transparent');
            writePanel.classList.remove('hidden');
            previewPanel.classList.add('hidden');
        } else {
            previewTab.classList.add('active', 'text-blue-600', 'dark:text-blue-400', 'bg-white', 'dark:bg-gray-900', 'border-blue-500');
            previewTab.classList.remove('text-gray-500', 'dark:text-gray-400', 'bg-gray-50', 'dark:bg-gray-800', 'border-transparent');
            writeTab.classList.remove('active', 'text-blue-600', 'dark:text-blue-400', 'bg-white', 'dark:bg-gray-900', 'border-blue-500');
            writeTab.classList.add('text-gray-500', 'dark:text-gray-400', 'bg-gray-50', 'dark:bg-gray-800', 'border-transparent');
            writePanel.classList.add('hidden');
            previewPanel.classList.remove('hidden');
            updatePreview();
        }
    }
    
    // Fullscreen toggle
    fullscreenToggle.addEventListener('click', () => {
        container.classList.toggle('fullscreen');
        if (container.classList.contains('fullscreen')) {
            fullscreenToggle.textContent = 'Exit Fullscreen';
            document.body.style.overflow = 'hidden';
        } else {
            fullscreenToggle.textContent = 'Fullscreen';
            document.body.style.overflow = '';
        }
    });
    
    // Toolbar actions
    document.querySelectorAll(`#toolbar-${editorId} .toolbar-btn`).forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.dataset.action;
            insertMarkdown(action);
        });
    });
    
    function insertMarkdown(action) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        let replacement = '';
        
        switch (action) {
            case 'bold':
                replacement = `**${selectedText || 'bold text'}**`;
                break;
            case 'italic':
                replacement = `*${selectedText || 'italic text'}*`;
                break;
            case 'heading':
                replacement = `## ${selectedText || 'Heading'}`;
                break;
            case 'code':
                replacement = selectedText.includes('\n') 
                    ? `\`\`\`\n${selectedText || 'code'}\n\`\`\`` 
                    : `\`${selectedText || 'code'}\``;
                break;
            case 'link':
                replacement = `[${selectedText || 'link text'}](url)`;
                break;
            case 'list':
                replacement = selectedText 
                    ? selectedText.split('\n').map(line => `- ${line}`).join('\n')
                    : '- List item';
                break;
            case 'quote':
                replacement = selectedText 
                    ? selectedText.split('\n').map(line => `> ${line}`).join('\n')
                    : '> Quote';
                break;
        }
        
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + replacement.length, start + replacement.length);
    }
    
    // Keyboard shortcuts
    textarea.addEventListener('keydown', (e) => {
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case 'b':
                    e.preventDefault();
                    insertMarkdown('bold');
                    break;
                case 'i':
                    e.preventDefault();
                    insertMarkdown('italic');
                    break;
            }
        }
    });
    
    // Update preview (simple markdown parsing)
    function updatePreview() {
        const content = textarea.value;
        // Simple markdown to HTML conversion (basic)
        let html = content
            .replace(/^### (.*$)/gim, '<h3>$1</h3>')
            .replace(/^## (.*$)/gim, '<h2>$1</h2>')
            .replace(/^# (.*$)/gim, '<h1>$1</h1>')
            .replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/gim, '<em>$1</em>')
            .replace(/`(.*?)`/gim, '<code>$1</code>')
            .replace(/^\> (.*$)/gim, '<blockquote>$1</blockquote>')
            .replace(/^\- (.*$)/gim, '<li>$1</li>')
            .replace(/\[([^\]]+)\]\(([^)]+)\)/gim, '<a href="$2">$1</a>')
            .replace(/\n/gim, '<br>');
            
        previewContent.innerHTML = html || '<p class="text-gray-500 dark:text-gray-400">Nothing to preview</p>';
    }
});
</script>