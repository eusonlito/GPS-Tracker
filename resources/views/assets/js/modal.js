(function () {
    const body = document.querySelector('body');
    const modals = document.querySelectorAll('.modal');

    if (!modals) {
        return;
    }

    const insertAfter = function (newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
    }

    const getHighestZindex = function () {
        let zIndex = 999;

        modals.forEach(element => {
            const current = element.style.zIndex;

            if ((current !== 'auto') && (current > zIndex)) {
                zIndex = parseInt(current);
            }
        });

        return zIndex;
    }

    const getScrollbarWidth = function (element) {
        if (typeof element === 'String') {
            element = document.querySelector(element);
        }

        return window.innerWidth - element.clientWidth;
    }

    const show = function (element) {
        if (!element) {
            return;
        }

        if (document.querySelector('[data-modal-replacer="' + element.id + '"]')) {
            return;
        }

        const div = document.createElement('div');

        div.dataset.modalReplacer = element.id;

        insertAfter(div, element);

        element.style.marginTop = 0;
        element.style.marginLeft = 0;

        element.ariaHidden = 'false';

        insertAfter(element, body);

        setTimeout(() => {
            element.classList.add('show');
            element.style.zIndex = getHighestZindex() + 1
        }, 200);

        body.style.paddingRight = parseInt(body.style.paddingRight) + getScrollbarWidth('html') + 'px';
        body.classList.add('overflow-y-hidden');

        modals.forEach(modal => {
            modal.classList.remove('overflow-y-auto');
            modal.style.paddingLeft = '0';
        });

        element.classList.add('overflow-y-auto');
        element.style.paddingLeft = getScrollbarWidth(element) + 'px';

        if (element.classList.contains('show')) {
            element.classList.add('modal-overlap');
        }
    }

    const hide = function (element) {
        if (!element) {
            return;
        }

        if (!element.classList.contains('modal') || !element.classList.contains('show')) {
            return;
        }

        element.ariaHidden = 'true';
        element.classList.remove('show');

        setTimeout(() => {
            element.style = {};
            element.classList.remove('modal-overlap', 'overflow-y-auto');

            modals.forEach(modal => {
                if (parseInt(modal.style.zIndex) !== getHighestZindex()) {
                    return;
                }

                modal.classList.add('overflow-y-auto');
                modal.style.paddingLeft = getScrollbarWidth(modal) + 'px';
            });

            if (getHighestZindex() === 999) {
                body.classList.remove('overflow-y-hidden');
                body.style.paddingRight = 0;
            }

            const current = document.querySelector('[data-modal-replacer="' + element.id + '"]');

            current.parentNode.replaceChild(element, current);
        }, parseFloat(element.style.transitionDuration.split(',')[1]) * 1000);
    }

    const toggle = function (element) {
        if (element.classList.contains('modal') && element.classList.contains('show')) {
            hide(element);
        } else {
            show(element);
        }
    }

    document.querySelectorAll('[data-toggle="modal"]').forEach(element => {
        element.addEventListener('click', () => show(document.querySelector(element.dataset.target)), false);
    });

    document.querySelectorAll('[data-dismiss="modal"]').forEach(element => {
        element.addEventListener('click', () => hide(element.closest('.modal')), false);
    });

    document.addEventListener('keydown', function (event) {
        if (event.code !== 'Escape') {
            return;
        }

        let element;

        modals.forEach(modal => {
            if (modal.classList.contains('show')) {
                element = modal;
            }
        })

        if (!element || !element.classList.contains('modal') || !element.classList.contains('show')) {
            return;
        }

        if (element.dataset.backdrop === undefined) {
            hide(element);
        } else {
            element.classList.add('modal-static');
            setTimeout(() => element.classList.remove('modal-static'), 600);
        }
    }, false);

    modals.forEach(modal => {
        modal.show = () => show(modal);
        modal.hide = () => hide(modal);
    });
})();
