$(function() {
    $('input.jk-color-picker').each(function() {

        var $this = $(this),
            color = $this.val();

        $this.ColorPicker({
            color: color,
            eventName: 'click focus',
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex)
                    .css({
                        'backgroundColor': '#' + hex
                    });
            }
        })
            .css({backgroundColor: color});
    })
});