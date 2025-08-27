import './bootstrap';
import Alpine from 'alpinejs';

// Import Prism for syntax highlighting with enhanced theme
import Prism from 'prismjs';
import 'prismjs/themes/prism-tomorrow.css';

// Import comprehensive programming languages that are available
import 'prismjs/components/prism-javascript.js';
import 'prismjs/components/prism-typescript.js';
import 'prismjs/components/prism-jsx.js';
import 'prismjs/components/prism-tsx.js';
import 'prismjs/components/prism-php.js';
import 'prismjs/components/prism-python.js';
import 'prismjs/components/prism-java.js';
import 'prismjs/components/prism-csharp.js';
import 'prismjs/components/prism-c.js';
import 'prismjs/components/prism-cpp.js';
import 'prismjs/components/prism-css.js';
import 'prismjs/components/prism-scss.js';
import 'prismjs/components/prism-sass.js';
import 'prismjs/components/prism-less.js';
import 'prismjs/components/prism-markup.js'; // HTML
import 'prismjs/components/prism-json.js';
import 'prismjs/components/prism-yaml.js';
import 'prismjs/components/prism-bash.js';
import 'prismjs/components/prism-powershell.js';
import 'prismjs/components/prism-sql.js';
import 'prismjs/components/prism-rust.js';
import 'prismjs/components/prism-go.js';
import 'prismjs/components/prism-kotlin.js';
import 'prismjs/components/prism-swift.js';
import 'prismjs/components/prism-ruby.js';
import 'prismjs/components/prism-perl.js';
import 'prismjs/components/prism-r.js';
import 'prismjs/components/prism-lua.js';
import 'prismjs/components/prism-vim.js';
import 'prismjs/components/prism-docker.js';
import 'prismjs/components/prism-nginx.js';
import 'prismjs/components/prism-latex.js';
import 'prismjs/components/prism-markdown.js';
import 'prismjs/components/prism-graphql.js';
import 'prismjs/components/prism-haskell.js';
import 'prismjs/components/prism-scala.js';
import 'prismjs/components/prism-dart.js';
import 'prismjs/components/prism-elixir.js';
import 'prismjs/components/prism-clojure.js';

// Import Prism plugins for enhanced features
import 'prismjs/plugins/line-numbers/prism-line-numbers.js';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.js';
import 'prismjs/plugins/toolbar/prism-toolbar.js';
import 'prismjs/plugins/toolbar/prism-toolbar.css';

window.Alpine = Alpine;
window.Prism = Prism;

Alpine.start();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('/serviceworker.js')
        .then(function(registration) {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(function(error) {
          console.error('Service Worker registration failed:', error);
        });
    });
  }

// Enhanced Prism initialization with advanced features
document.addEventListener('DOMContentLoaded', function() {
    
    // Function to enhance code blocks
    function enhanceCodeBlocks() {
        const codeBlocks = document.querySelectorAll('pre[class*="language-"]');
        
        codeBlocks.forEach(block => {
            // Add language label
            const language = block.className.match(/language-(\w+)/)?.[1];
            if (language) {
                block.setAttribute('data-language', language);
            }
            
            // Add line numbers to longer code blocks
            const codeContent = block.querySelector('code');
            if (codeContent && codeContent.textContent.split('\n').length > 3) {
                block.classList.add('line-numbers');
            }
            
            // Wrap in container for copy button
            if (!block.parentElement.classList.contains('code-block-wrapper')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'code-block-wrapper';
                block.parentNode.insertBefore(wrapper, block);
                wrapper.appendChild(block);
                
                // Add custom copy button
                const copyButton = document.createElement('button');
                copyButton.className = 'copy-code-button';
                copyButton.textContent = 'Copy';
                copyButton.addEventListener('click', () => {
                    const code = block.querySelector('code').textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        copyButton.textContent = 'Copied!';
                        copyButton.classList.add('copied');
                        setTimeout(() => {
                            copyButton.textContent = 'Copy';
                            copyButton.classList.remove('copied');
                        }, 2000);
                    });
                });
                wrapper.appendChild(copyButton);
            }
        });
    }
    
    // Initial highlighting and enhancement
    Prism.highlightAll();
    enhanceCodeBlocks();
    
    // Re-highlight and enhance when content is dynamically loaded
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    Prism.highlightAll();
                    enhanceCodeBlocks();
                }, 100);
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});