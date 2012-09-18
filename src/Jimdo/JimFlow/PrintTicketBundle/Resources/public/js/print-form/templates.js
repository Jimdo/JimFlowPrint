$(function () {
    var $statusElm = $('#print-headline span.status');

    $.printForm({

        success:function () {
            $statusElm.removeClass('loading').addClass('ok');
        },
        error:function () {
            $statusElm.removeClass('loading').addClass('fail');
        },
        before:function ($container, $button) {
            var self = this;
            $container.addClass('inactive');
            $button.addClass('chosen');
            $statusElm.removeClass('fail ok').addClass('loading');
        },
        complete:function ($container, $button) {
            var self = this;
            $statusElm.removeClass('loading');
            $container.removeClass('inactive');
            $button.removeClass('chosen');
        }
    });
})
