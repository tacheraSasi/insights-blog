<?php

namespace App\Helpers;

class TableOfContents
{
    /**
     * Generate table of contents from markdown content
     * 
     * @param string $content
     * @return array
     */
    public static function generate(string $content): array
    {
        $toc = [];
        
        // Match all markdown headers (# to ######)
        preg_match_all('/^(#{1,6})\s+(.+)$/m', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $level = strlen($match[1]); // Number of # characters
            $title = trim($match[2]);
            $id = self::createId($title);
            
            $toc[] = [
                'level' => $level,
                'title' => $title,
                'id' => $id,
                'children' => []
            ];
        }
        
        return $toc;
    }

    /**
     * Generate HTML for table of contents
     * 
     * @param array $toc
     * @return string
     */
    public static function generateHtml(array $toc): string
    {
        if (empty($toc)) {
            return '';
        }

        $html = '<div class="table-of-contents bg-gray-50 dark:bg-gray-800 p-6 rounded-lg mb-8">';
        $html .= '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Table of Contents</h3>';
        $html .= '<ul class="space-y-2">';
        
        foreach ($toc as $item) {
            $indent = ($item['level'] - 1) * 1.5; // 1.5rem per level
            $html .= '<li style="margin-left: ' . $indent . 'rem;">';
            $html .= '<a href="#' . $item['id'] . '" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">';
            $html .= htmlspecialchars($item['title']);
            $html .= '</a>';
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Add IDs to headers in content for linking
     * 
     * @param string $content
     * @return string
     */
    public static function addHeaderIds(string $content): string
    {
        return preg_replace_callback(
            '/^(#{1,6})\s+(.+)$/m',
            function ($matches) {
                $level = strlen($matches[1]);
                $title = trim($matches[2]);
                $id = self::createId($title);
                
                return $matches[1] . ' <span id="' . $id . '"></span>' . $title;
            },
            $content
        );
    }

    /**
     * Create a URL-friendly ID from title
     * 
     * @param string $title
     * @return string
     */
    private static function createId(string $title): string
    {
        // Remove special characters and convert to lowercase
        $id = strtolower($title);
        $id = preg_replace('/[^a-z0-9\s-]/', '', $id);
        $id = preg_replace('/\s+/', '-', $id);
        $id = trim($id, '-');
        
        return $id ?: 'section';
    }

    /**
     * Check if content has enough headers to warrant a TOC
     * 
     * @param string $content
     * @param int $minHeaders
     * @return bool
     */
    public static function shouldShowToc(string $content, int $minHeaders = 3): bool
    {
        preg_match_all('/^#{1,6}\s+.+$/m', $content, $matches);
        return count($matches[0]) >= $minHeaders;
    }
}