# Commentable - HTML Comments Extension

Converts comment content fields to WYSIWYGs on frontend and backend

Requires
* [Flynsarmy.Commentable](https://octobercms.com/plugin/flynsarmy-commentable) plugin 

## Installation

* `git clone` to */plugins/flynsarmy/commentablehtml*
* Copy */plugins/flynsarmy/commentable/components/comments* to */themes/yourtheme/partials/comments*
* In */themes/yourtheme/partials/comments/comment.htm* change `{{ comment.renderedContent }}` to
  ```
  {% if usingHtmlComments %}
      {{ comment.renderedContent|raw }}
  {% else %}
      {{ comment.renderedContent }}
  {% endif %}
  ```
* In the backend go to *Comments - Settings - General* and check *Enable HTML comments?* checkbox

