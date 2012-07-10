(function ($) {

    /**
     *
     * @constructor
     */
    function ButtonForm() {
        var self = this,
            args = Array.prototype.slice.call(arguments);

        if ($.isFunction(self.init)) {

            self.init.apply(self, args);
        }
    }

    /**
     *
     * @type {Object}
     */
    ButtonForm.prototype = {

        /**
         *
         * @param options
         */
        init:function (options) {
            var self = this;
            self.options = options[0];

            self.$printButtonsContainer = $('#printer-buttons');
            self.$printButtons = self.$printButtonsContainer.find('div:not(.inactive)');
            self.pendingRequest = false;
            self.$form = $('#kanban_form');

            self.bindButtonClick();
        },

        /**
         * Prevent the form from being submitted ecept for click on a button
         */
        bindFormSubmit: function () {
            var self = this;
            self.$form.bind('submit', function () {
                return false;
            });
        },

        /**
         * Trigger form submit
         */
        bindButtonClick: function () {
            var self = this;

            self.$printButtons.bind('click', function () {
                self.$currentButton = $(this);
                self.submitForm($(this).attr('data-id'));
            });
        },

        /**
         * actual submitting the form to print the ticket
         * @param printerId
         * @return {Boolean}
         */
        submitForm:function (printerId) {
            var self = this,
                data = self.$form.serialize() + '&printer=' + printerId,
                printUrl = self.$form.attr('action'),
                options = self.options;

            if (self.isRequestPending()) {
                return false;
            }

            self.$printButtonsContainer.addClass('inactive');

            self.before.call(self);

            $.ajax({
                url:printUrl,
                data:data,
                type:'post',
                success:function () {
                    self.success.apply(self);
                },
                error:function () {
                   self.error.apply(self);
                },
                complete:function () {
                    self.complete.apply(self);
                }
            });
        },

        /**
         * determine whether a request is in progress
         * @return bool
         */
        isRequestPending:function () {
            var self = this;

            return self.pendingRequest;
        },

        /**
         * If something doesnt work during print
         */
        error:function () {
            var self = this;

            self.callCb(self.options.error, self);
        },

        /**
         * before the ajax call is made
         */
        before: function() {
            var self = this;

            self.pendingRequest = true;
            self.callCb(self.options.before, self);
        },

        /**
         * after the ajax call is made. Triggered for error and success
         */
        complete:function () {
            var self = this;

            self.pendingRequest = false;
            self.callCb(self.options.complete, self);
        },

        /**
         * ajax call was successfull
         */
        success:function () {
            var self = this;
            self.callCb(self.options.success, self);
        },

        /**
         * helper method to call a callback
         * @param cb
         * @param scope
         */
        callCb:function (cb, scope) {
            var self = this;

            if (!$.isFunction(cb)) {
                cb = $.noop;
            }

            cb.call(scope, self.$printButtonsContainer, self.$currentButton);
        }
    }

    /**
     * Small and yet unflexible plugin to print tickets/stories
     * It's a plugin to have the possibility to react differently on certain callbacks (success, error etc). e.g.
     * the "normal" form behaves not like the iframe version of the print buttons. (They don't have that nice pacman :) )
     */
    $.printForm = function() {
        var options = Array.prototype.slice.call(arguments);
        new ButtonForm(options);
    }


})(jQuery);



