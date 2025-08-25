<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Function to check for dark mode
    function isDarkMode() {
        return document.documentElement.classList.contains('dark') || 
               window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    // Initialize TinyMCE with enhanced features
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autosave'
        ],
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | help | ' +
                'link image media | table | code preview fullscreen',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px }',
        skin: isDarkMode() ? 'oxide-dark' : 'oxide',
        content_css: isDarkMode() ? 'dark' : 'default',
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: 'tinymce-autosave-{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_context_toolbar: true,
        branding: false,
        promotion: false,
        setup: function (editor) {
            editor.on('init', function () {
                // Apply theme based on current mode
                const container = editor.getContainer();
                if (isDarkMode()) {
                    container.classList.add('dark');
                }
                
                // Update word count in external element
                editor.on('keyup', function () {
                    const wordCount = editor.plugins.wordcount.getCount();
                    const charCount = editor.getContent({format: 'text'}).length;
                    
                    const statsEl = document.getElementById('editor-stats');
                    if (statsEl) {
                        statsEl.innerHTML = `${wordCount} words • ${charCount} characters`;
                    }
                });
            });

            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const currentTheme = isDarkMode() ? 'oxide-dark' : 'oxide';
                        if (editor.getParam('skin') !== currentTheme) {
                            // Theme changed, update editor
                            editor.execCommand('mceToggleFormat', false, 'code');
                        }
                    }
                });
            });
            
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
</script>
