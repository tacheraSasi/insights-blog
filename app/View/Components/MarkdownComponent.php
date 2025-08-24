<?php

namespace App\View\Components;

use Illuminate\View\Component;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdown\GithubFlavoredMarkdownExtension;

class MarkdownComponent extends Component
{
    public $markdown;

    public function __construct($markdown)
    {
        $this->markdown = $markdown;
    }

    public function render()
    {
        return view('components.markdown-component');
    }

    public function parsedMarkdown()
    {
        // Create an environment with GitHub Flavored Markdown
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ], $environment);
        
        return $converter->convertToHtml($this->markdown);
    }
}
