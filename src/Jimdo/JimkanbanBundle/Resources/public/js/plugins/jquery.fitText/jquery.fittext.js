(function($) {
    function FitText(element, options) {
        var self = this,
            opts = {};

        self.defaults = $.fn.fitText.defaults;

        $.extend(true, opts, self.defaults, options);
        self.options = opts;


        if ($.isFunction(self.init)) {
            self.init.call(self, element);
        }
    }

    FitText.prototype = {
        /**
         * init the plugin
         * @param element
         */
        init: function(element) {
            var self = this;

            self.$element = $(element);

            if (!self.isMinCharCountSatisfied()) {
                return;
            }

            self.assertPxIsPositiveNumber();
            self.run();
        },

        /**
         * run the plugin
         */
        run: function() {
            var self = this;

            self.setCssClass();
            self.enlarge();
            self.removeCssClass();
        },

        /**
         * set css class to element to ensure overflow is auto
         */
        setCssClass: function() {
            var self = this;

            self.$element.addClass(self.options.cssClassName);
        },

        /**
         * remove the css class
         */
        removeCssClass: function() {
            var self = this;

            self.$element.removeClass(self.options.cssClassName);
        },

        /**
         * check that px option is a positive number
         */
        assertPxIsPositiveNumber: function() {
            var self = this,
                px = self.options.px;

            if (!px || px <= 0 || typeof px !== 'number') {
                throw Error("px needs to be a positive number");
            }
        },

        isMinCharCountSatisfied: function() {
            var self = this;

            return (self.$element.text().length >= self.options.minimumCharCount)
        },

        /**
         * Determine if element has horizontal or vertical scrollbar
         */
        hasScrollbar: function() {
            var self = this,
                element = self.$element[0];

            return (element.clientHeight < element.scrollHeight) || (element.clientWidth < element.scrollWidth);
        },

        /**
         * Adjust font size until no scrollbar is left or until it's present
         * depending on given px
         * @param number px
         */
        setFontSize: function(px) {
            var self = this,
                hasScrollBar;

            do {
                self.$element.css({fontSize: '+=' + px});
                hasScrollBar = self.hasScrollbar();

            } while (px > 0 ? !hasScrollBar : hasScrollBar)
        },

        /**
         * Shrink font size until scrollbars are gone
         */
        shrink: function() {
            var self = this;

            self.setFontSize(self.options.px * -1);
        },

        /**
         * Enlarge font size until scrollbar appears
         */
        enlarge: function() {
            var self = this;

            self.setFontSize(self.options.px);
            self.shrink()
        }
    };

    $.fn.extend({
        fitText: function() {
            var options = arguments[0];
            return this.each(function() {
                new FitText(this, options);
            });
        }
    });

    $.fn.fitText.defaults = {
        px: 1, //pixel the font size get in/decreaed per iteration. More is less accurate but faster
        cssClassName: 'fit-text', //class used to set overflow to auto
        minimumCharCount: 1 //Chars the text should have at least
    };
}(jQuery));