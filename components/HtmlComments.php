<?php

namespace Flynsarmy\CommentableHtml\Components;

use Cms\Classes\ComponentBase;
use Flynsarmy\Commentable\Models\Settings;

class HtmlComments extends ComponentBase
{
    protected $commentsComponent;

    public function componentDetails()
    {
        return [
            'name'        => 'HTML Comments',
            'description' => 'Converts Commentable comments to HTML',
        ];
    }

    public function onRun()
    {
        if ($this->usingHtmlComments()) {
            $this->addCss('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/ui/trumbowyg.min.css');
            $this->addJs('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/trumbowyg.min.js');
            $this->addJs('assets/js/script.js');
        }

        $this->page['usingHtmlComments'] = $this->usingHtmlComments();
    }

    public function usingHtmlComments()
    {
        return Settings::instance()->get('enable_html_comments', false);
    }
}
