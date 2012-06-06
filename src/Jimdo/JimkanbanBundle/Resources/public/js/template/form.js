(function($) {
    $(function() {
        var self = this;

        this.markStatusLoading = function() {
            var that = self;

            that.$statusElm.removeClass('fail ok')
                .addClass('loading');
        };

        this.markStatusOk = function() {
            var that = self;

            that.$statusElm.removeClass('loading').addClass('ok');
        };

        this.markStatusFail = function() {
            var that = self;

            that.$statusElm.removeClass('loading').addClass('fail');
        };

        this.error = function() {
            var that = self;

            that.markStatusFail();
        };

        this.complete = function() {
            var that = self;

            that.pendingRequest = false;
            that.$statusElm.removeClass('loading');
            that.$printButtonsContainer.removeClass('inactive');
        };

        this.success = function() {
            var that = self;

            that.markStatusOk();
        };

        this.isRequestPending = function() {
            var that = self;

            return that.pendingRequest;
        };

        this.bindButtonClick = function() {
            var that = self;

            that.$printButtons.bind('click', function() {
                that.submitForm($(this).attr('data-id'));
            });
        };

        this.submitForm = function(printerId) {
            var that = this,
                data = that.$form.serialize() + '&printer=' + printerId,
                printUrl = that.$form.attr('action');

            if (that.isRequestPending()) {
                return false;
            }

            that.pendingRequest = true;

            that.markStatusLoading();
            that.$printButtonsContainer.addClass('inactive');

            $.ajax({
                url: printUrl,
                data: data,
                type: 'post',
                success: that.success,
                error: that.error,
                complete: that.complete
            });
        };

        this.bindFormSubmit = function() {
            var that = self;
            that.$form.bind('submit', function() {
                return false;
            });
        };

        this.init = function() {
            var that = self;

            that.$printButtonsContainer = $('#printer-buttons');
            that.$printButtons = that.$printButtonsContainer.find('div');
            that.pendingRequest = false;
            that.$statusElm = $('#print-headline span.status');
            that.$form = $('#kanban_form');

            that.bindButtonClick();
            that.bindFormSubmit();
        }

        this.init();


    });
})(jQuery);

