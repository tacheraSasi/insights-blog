import { document } from 'postcss';
import './bootstrap';
// import {MarkdownBlock, MarkdownSpan, MarkdownElement} from "md-block";
// import {URLs as MdBlockURLS, MarkdownBlock, MarkdownSpan, MarkdownElement} from "md-block.js";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// MdBlockURLS.Prism = "./prism.js";
// // You can optionally also provide a Prism CSS URL:
// MdBlockURLS.PrismCSS = "./prism.css";

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