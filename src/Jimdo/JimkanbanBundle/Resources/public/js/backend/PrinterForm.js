$(function() {
    var $printerForm = $('#printer_edit_form'),
        $stateInput =  $('#printer_edit_form').find('input[type=hidden].is-active'),
        state;

    $('#deactivate').on('click', function() {
        state = $stateInput.val();
        $stateInput.val(state == 1 ? 0 : 1);
        $('#printer_edit_form').submit();
    });
});