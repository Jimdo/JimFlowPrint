$(function () {
    var $statusElm = $('#print-headline span.status');

    $.printForm({

        success:function () {
            $statusElm.removeClass('loading').addClass('ok');
        },
        error:function () {
            $statusElm.removeClass('loading').addClass('fail');
        },
        before:function ($container) {
            var self = this;

            $container.addClass('inactive');
            $statusElm.removeClass('fail ok').addClass('loading');
        },
        complete:function ($container) {
            var self = this;
            $statusElm.removeClass('loading');
            $container.removeClass('inactive');
        }
    });
})