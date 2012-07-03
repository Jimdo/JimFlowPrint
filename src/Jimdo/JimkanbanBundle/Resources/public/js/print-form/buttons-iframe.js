$(function () {
    $.printForm({
        before:function ($container) {
            $container.addClass('inactive');
        },
        complete:function ($container) {
            $container.removeClass('inactive');
        },
        error:function () {
            alert('Something went wrong while trying to print your ticket. Sorry for that :(');
        }

    })
})