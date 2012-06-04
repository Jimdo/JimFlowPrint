(function($) {
    $(function() {
        var $printButtons = $('button');
        $printButtons.bind('click', function() {
            $printButtons.removeClass('active');
            $(this).addClass('active');
        });

        $('#kanban_form').bind('submit', function() {
            var $this = $(this),
                printerId = $printButtons.siblings('.active:first').attr('data-id'),
                data = $this.serialize() + '&printer=' + printerId,
                printUrl = $this.attr('action'),
                $statusElm = $('#print-headline span.status');

            $statusElm.removeClass('fail ok').addClass('loading');

            $.ajax({
                url: printUrl,
                data: data,
                type: 'post',
                success: function() {
                    $statusElm.addClass('ok');
                },
                error: function() {
                    $statusElm.addClass('fail');
                },
                complete: function() {
                    $statusElm.removeClass('loading');
                }
            });


            return false;
        });
    });
})(jQuery);

