$(function() {

    function supportsColorInput() {
        var input = document.createElement('input');
        input.setAttribute('type', 'color');

        return input.type === 'color';
    }

    if (supportsColorInput()) {
        return;
    }

    $('input.jk-color-picker').each(function() {

        var $this = $(this),
            color = $this.val();

        $this.ColorPicker({
            color: color,
            eventName: 'click focus',
            onChange: function(hsb, hex) {
                $this.css({
                    'backgroundColor': '#' + hex
                }).val('#' + hex)
            }
        })
            .css({backgroundColor: color});
    })
});