(function () {
    'use strict';

    const search = function (e, element) {
        if ((e.code === 'Enter') || (e.code === 'NumpadEnter')) {
            return e.preventDefault();
        }

        if (e.type !== 'keyup') {
            return;
        }

        const $table = document.querySelector(element.dataset.tableSearch);
        const $trs = $table.querySelectorAll('tbody > tr');
        const value = element.value.toLowerCase().replace(/^\s+/, '').replace(/\s+$/, '');

        if (!value.length) {
            return searchReset($table, $trs);
        }

        $table.dispatchEvent(new CustomEvent('search', { detail: value }));

        $trs.forEach(function (tr) {
            tr.style.display = ((tr.textContent || tr.innerText).toLowerCase().indexOf(value) > -1) ? 'table-row' : 'none';
        });
    };

    const searchReset = function ($table, $trs) {
        $trs.forEach(function (tr) {
            tr.style.display = (tr.dataset.tablePaginationHidden === 'true') ? 'none' : 'table-row';
        });

        $table.dispatchEvent(new CustomEvent('search', { detail: '' }));
    };

    function load(element) {
        if (element.dataset.tableSortLoaded) {
            return;
        }

        element.addEventListener('keyup', (e) => search(e, element));

        element.dataset.tableSortLoaded = true;
    }

    function init () {
        document.querySelectorAll('[data-table-search]').forEach(load);
    }

    document.addEventListener('ajax', init);

    init();
})();
