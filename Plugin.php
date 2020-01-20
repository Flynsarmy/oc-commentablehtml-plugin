<?php namespace Flynsarmy\CommentableHtml;

use Event;
use System\Classes\PluginBase;

/**
 * Commentable Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['Flynsarmy.Commentable'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Commentable - HTML Comments Extension',
            'description' => 'Allows comments to be made with a WYSIWYG editor.',
            'author'      => 'Flynsarmy',
            'icon'        => 'icon-comments'
        ];
    }

    public function registerComponents()
    {
        return [
            'Flynsarmy\CommentableHtml\Components\HtmlComments'   => 'htmlcomments',
        ];
    }

    public function boot()
    {
        $useHtml = \Flynsarmy\Commentable\Models\Settings::instance()->get('enable_html_comments', false);

        if ( $useHtml )
        {
            \Flynsarmy\Commentable\Models\Comment::extend(function($model) {
                $model->bindEvent('model.getAttribute', function($attribute, $value) use ($model) {
                    if ( $attribute == 'renderedContent' )
                        return htmlspecialchars_decode($model->content);

                    return null;
                });
            });

            // Convert backend to content field to a richeditor
            Event::listen('backend.form.extendFieldsBefore', function(\Backend\Widgets\Form $form) {
                if (
                    !$form->getController() instanceof \Flynsarmy\Commentable\Controllers\Threads &&
                    !$form->getController() instanceof \Flynsarmy\Commentable\Controllers\Notifications
                )
                    return;
                if ( !$form->model instanceof \Flynsarmy\Commentable\Models\Comment ) return;
                if ( !in_array($form->getContext(), ['update', 'edit']) ) return;

                if ( isset($form->fields['content']) )
                    $form->fields['content']['type'] = 'richeditor';
            });
        }

        // Add setting to toggle HTML forms on and off
        Event::listen('backend.form.extendFieldsBefore', function(\Backend\Widgets\Form $form) {
            if (
                !$form->getController() instanceof \Flynsarmy\Commentable\Controllers\Settings
            )
                return;
            if ( !$form->model instanceof \Flynsarmy\Commentable\Models\Settings ) return;
            if ( !in_array($form->getContext(), ['update', 'edit']) ) return;

            $form->tabs['fields']['enable_html_comments'] = [
                'label' => 'Enable HTML comments?',
                'type' => 'checkbox',
                'comment' => "Comments are edited in a WYSIWYG editor and full HTML markup displayed",
                'tab' => 'General',
            ];
        });
    }
}
