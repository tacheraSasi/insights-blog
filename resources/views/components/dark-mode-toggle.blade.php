<div x-data="darkModeToggle()" class="flex items-center">
    <button 
        @click="toggleDarkMode()"
        class="relative inline-flex items-center justify-center w-10 h-6 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800"
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
    >
        <!-- Toggle Circle -->
        <div 
            class="absolute w-4 h-4 bg-white dark:bg-gray-200 rounded-full shadow-sm transform transition-transform duration-200 ease-in-out"
            :class="isDark ? 'translate-x-4' : 'translate-x-0'"
        ></div>
        
        <!-- Sun Icon -->
        <svg 
            class="absolute left-1 w-3 h-3 text-yellow-500 transition-opacity duration-200"
            :class="isDark ? 'opacity-0' : 'opacity-100'"
            fill="currentColor" 
            viewBox="0 0 20 20"
        >
            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
        </svg>
        
        <!-- Moon Icon -->
        <svg 
            class="absolute right-1 w-3 h-3 text-gray-400 transition-opacity duration-200"
            :class="isDark ? 'opacity-100' : 'opacity-0'"
            fill="currentColor" 
            viewBox="0 0 20 20"
        >
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
    </button>
</div>

<script>
function darkModeToggle() {
    return {
        isDark: false,
        
        init() {
            // Check for saved preference or default to system preference
            this.isDark = localStorage.getItem('darkMode') === 'true' || 
                         (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            this.applyTheme();
        },
        
        toggleDarkMode() {
            this.isDark = !this.isDark;
            localStorage.setItem('darkMode', this.isDark);
            this.applyTheme();
        },
        
        applyTheme() {
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }
}

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
    const isDark = localStorage.getItem('darkMode') === 'true' || 
                  (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    if (isDark) {
        document.documentElement.classList.add('dark');
    }
});
</script>