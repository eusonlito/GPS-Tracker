import Velocity from 'velocity-animate';

(function () {
    'use strict';

    document.querySelectorAll('.side-menu').forEach((menu) => {
        menu.addEventListener('click', (e) => {
            const ul = menu.parentNode.querySelector('ul');

            if (!ul) {
                return;
            }

            if (ul.offsetParent) {
                menu.querySelector('.side-menu__sub-icon').classList.remove('transform', 'rotate-180');

                Velocity(ul, 'slideUp', {
                    duration: 300,
                    complete: el => menu.classList.remove('menu__sub-open'),
                });
            } else {
                menu.querySelector('.side-menu__sub-icon').classList.add('transform', 'rotate-180');

                Velocity(ul, 'slideDown', {
                    duration: 300,
                    complete: el => menu.classList.add('menu__sub-open'),
                });
            }
        });
    });
})();
