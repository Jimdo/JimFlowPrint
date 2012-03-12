$(function() {
    $('input.jk-color-picker').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val(hex)
            .css({
                'backgroundColor': '#' + hex
            });
        }
    })
    .css({backgroundColor: function() {
        return '#' + $(this).val()
    }});
});