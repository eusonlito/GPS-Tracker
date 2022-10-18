(function (cash) {
    // Show or hide global event listener
    let events = [];

    // Get highest z-index
    function getHighestZindex() {
        let zIndex = 52;

        cash('.modal').each(function () {
            if ((cash(this).css('z-index') !== 'auto') && (cash(this).css('z-index') > zIndex)) {
                zIndex = parseInt(cash(this).css('z-index'));
            }
        });

        return zIndex;
    }

    // Get scrollbar width
    function getScrollbarWidth(el) {
        return window.innerWidth - cash(el)[0].clientWidth;
    }

    // Show modal with z-index
    function show(el) {
        const element = cash(el);

        if (cash("[data-modal-replacer='" + element.attr("id") + "']").length) {
            return;
        }

        // Move modal element to body
        cash('<div data-modal-replacer="' + element.attr("id") + '"></div>').insertAfter(el);

        cash(el).css({
            'margin-top': 0,
            'margin-left': 0,
        });

        element.attr('aria-hidden', false).appendTo('body');

        // Show modal by highest z-index
        setTimeout(() => element.addClass('show').css('z-index', getHighestZindex() + 1), 200);

        // Setting up modal scroll
        cash('body').css('padding-right', parseInt(cash('body').css('padding-right')) + getScrollbarWidth('html') + 'px')
            .addClass('overflow-y-hidden');

        cash('.modal').removeClass('overflow-y-auto').css('padding-left', '0px');

        element.addClass('overflow-y-auto').css('padding-left', getScrollbarWidth(el) + 'px')
            .addClass(cash('.modal.show').length ? 'modal-overlap' : '');

        // Trigger callback function
        events.forEach(function (val, key) {
            if (element.attr('id') == cash(val.el).attr('id') && (val.event === 'on.show')) {
                events[key].triggerCallback = true;
            }
        });
    }

    // Hide modal & remove modal scroll
    function hide(el) {
        const element = cash(el);

        if (element.hasClass('modal') && element.hasClass('show')) {
            element.attr('aria-hidden', true).removeClass('show');

            setTimeout(() => {
                element.removeAttr('style').removeClass('modal-overlap').removeClass('overflow-y-auto');

                // Add scroll to highest z-index modal if exist
                cash('.modal').each(function () {
                    if (parseInt(cash(this).css('z-index')) === getHighestZindex()) {
                        cash(this).addClass('overflow-y-auto').css('padding-left', getScrollbarWidth(this) + 'px');
                    }
                });

                // Return back scroll to body if no more modal showed up
                if (getHighestZindex() == 52) {
                    cash('body').removeClass('overflow-y-hidden').css('padding-right', '');
                }

                // Return back modal element to it's first place
                cash('[data-modal-replacer="' + element.attr("id") + '"]').replaceWith(el);
            }, parseFloat(element.css('transition-duration').split(',')[1]) * 1000);

            // Trigger callback function
            events.forEach(function (val, key) {
                if (element.attr('id') == cash(val.el).attr('id') && (val.event === 'on.hide')) {
                    events[key].triggerCallback = true;
                }
            });
        }
    }

    // Toggle modal
    function toggle(el) {
        const element = cash(el);

        if (element.hasClass('modal') && element.hasClass('show')) {
            hide(el);
        } else {
            show(el);
        }
    }

    // On show
    function onShow(el, callback) {
        events[events.length] = {
            el: el,
            event: 'on.show',
            triggerCallback: false,
            callback: callback,
        };
    }

    // On hide
    function onHide(el, callback) {
        events[events.length] = {
            el: el,
            event: 'on.hide',
            triggerCallback: false,
            callback: callback,
        };
    }

    // Show modal
    cash("body").on("click", 'a[data-toggle="modal"]', function () {
        show(cash(this).attr('data-target'));
    });

    // Hide modal
    cash('body').on('click', function (event) {
        const target = cash(event.target);

        if (target.hasClass('modal') && target.hasClass('show')) {
            if (target.data('backdrop') === undefined) {
                hide(event.target);
            } else {
                target.addClass('modal-static');
                setTimeout(() => target.removeClass('modal-static'), 600);
            }
        }
    });

    // Dismiss modal by link
    cash("body").on("click", '[data-dismiss="modal"]', function () {
        hide(cash(this).closest('.modal')[0]);
    });

    // Detect show or hide event
    setInterval(function () {
        events.forEach(function (val, key) {
            if (val.event === 'on.show' && val.triggerCallback) {
                val.callback();
                events[key].triggerCallback = false;
            } else if (val.event === 'on.hide' && val.triggerCallback) {
                val.callback();
                events[key].triggerCallback = false;
            }
        });
    }, 300);

    // Keyboard event
    document.addEventListener('keydown', function (event) {
        if (event.code !== 'Escape') {
            return;
        }

        const el = cash('.modal.show').last();
        const element = cash(el);

        if (element.hasClass('modal') && element.hasClass('show')) {
            if (element.data('backdrop') === undefined) {
                hide(el);
            } else {
                element.addClass('modal-static');
                setTimeout(() => element.removeClass('modal-static'), 600);
            }
        }
    });

    cash.fn.modal = function (event, callback) {
        if (event == 'show') {
            show(this);
        } else if (event === 'hide') {
            hide(this);
        } else if (event === 'toggle') {
            toggle(this);
        } else if (event === 'on.show') {
            onShow(this, callback);
        } else if (event === 'on.hide') {
            onHide(this, callback);
        }
    };
})(cash);
