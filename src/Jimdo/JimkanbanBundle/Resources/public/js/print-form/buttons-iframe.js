$(function () {
    $.printForm({
        before:function ($container, $button) {
            $container.addClass('inactive');
            $button.addClass('chosen');
        },
        complete:function ($container, $button) {
            $container.removeClass('inactive');
            $button.removeClass('chosen');
        },
        error:function () {
            alert('Something went wrong while trying to print your ticket. Sorry for that :(');
        }

    });
});