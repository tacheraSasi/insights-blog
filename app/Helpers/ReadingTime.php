<?php

namespace App\Helpers;

class ReadingTime
{
    /**
     * Calculate reading time based on content
     * Average reading speed is 200-250 words per minute
     * 
     * @param string $content
     * @param int $wpm Words per minute (default 200)
     * @return array
     */
    public static function calculate(string $content, int $wpm = 200): array
    {
        // Strip HTML tags and markdown syntax
        $cleanContent = strip_tags($content);
        $cleanContent = preg_replace('/[^\w\s]/', ' ', $cleanContent);
        
        // Count words
        $wordCount = str_word_count($cleanContent);
        
        // Calculate time in minutes
        $timeInMinutes = ceil($wordCount / $wpm);
        
        // Ensure minimum 1 minute
        $timeInMinutes = max(1, $timeInMinutes);
        
        return [
            'words' => $wordCount,
            'minutes' => $timeInMinutes,
            'time_text' => $timeInMinutes . ' min read'
        ];
    }

    /**
     * Generate a reading time estimate with icons
     * 
     * @param string $content
     * @return string
     */
    public static function getReadingTimeHtml(string $content): string
    {
        $reading = self::calculate($content);
        
        return '<span class="reading-time inline-flex items-center text-sm text-gray-600 dark:text-gray-400">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ' . $reading['time_text'] . ' • ' . number_format($reading['words']) . ' words
        </span>';
    }
}