import './bootstrap';
import Alpine from 'alpinejs';

// Import Prism for syntax highlighting
import Prism from 'prismjs';
import 'prismjs/themes/prism-tomorrow.css';

// Import common programming languages
import 'prismjs/components/prism-javascript.js';
import 'prismjs/components/prism-typescript.js';
import 'prismjs/components/prism-php.js';
import 'prismjs/components/prism-python.js';
import 'prismjs/components/prism-java.js';
import 'prismjs/components/prism-csharp.js';
import 'prismjs/components/prism-css.js';
import 'prismjs/components/prism-markup.js'; // HTML
import 'prismjs/components/prism-json.js';
import 'prismjs/components/prism-bash.js';
import 'prismjs/components/prism-sql.js';
import 'prismjs/components/prism-rust.js';
import 'prismjs/components/prism-go.js';

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

// Initialize Prism after page load
document.addEventListener('DOMContentLoaded', function() {
    // Highlight all code blocks on page load
    Prism.highlightAll();
    
    // Re-highlight when content is dynamically loaded
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                Prism.highlightAll();
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});