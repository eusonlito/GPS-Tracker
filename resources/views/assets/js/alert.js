import Velocity from 'velocity-animate';

(function () {
    'use strict';

    document.querySelectorAll('.btn-close').forEach(element => {
        element.addEventListener('click', (e) => {
            Velocity(element.closest('.alert'), 'fadeOut', {
                duration: 300,
                complete: el => element.classList.remove('show'),
            });
        });
    });
})();
