import Velocity from 'velocity-animate';

(function () {
    'use strict';

    const mobileMenu = document.querySelector('.mobile-menu');

    if (!mobileMenu) {
        return;
    }

    const mobileMenuUl = mobileMenu.querySelector('ul');

    document.getElementById('mobile-menu-toggler').addEventListener('click', (e) => {
        e.preventDefault();

        Velocity(mobileMenuUl, mobileMenuUl.offsetParent ? 'slideUp' : 'slideDown');
    });

    mobileMenu.querySelectorAll('.menu').forEach((menu) => {
        menu.addEventListener('click', (e) => {
            const ul = menu.parentNode.querySelector('ul');

            if (!ul) {
                return;
            }

            if (ul.offsetParent) {
                menu.querySelector('.menu__sub-icon').classList.remove('transform', 'rotate-180');

                Velocity(ul, 'slideUp', {
                    duration: 300,
                    complete: el => menu.classList.remove('menu__sub-open'),
                });
            } else {
                menu.querySelector('.menu__sub-icon').classList.add('transform', 'rotate-180');

                Velocity(ul, 'slideDown', {
                    duration: 300,
                    complete: el => menu.classList.add('menu__sub-open'),
                });
            }
        });
    });
})();
