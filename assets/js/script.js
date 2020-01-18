jQuery(document).ready(function($) {
    var setupTrumbowyg = function() {
        $('.commentable textarea').trumbowyg({
            btns: [
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['unorderedList', 'orderedList'],
                ['removeformat'],
            ]
        });
    };

    setupTrumbowyg();

    $(document).on('render', function() {
        setupTrumbowyg();
    });
});