(function () {
    'use strict';

    const search = function (e, element, $table, $trs) {
        if ((e.code === 'Enter') || (e.code === 'NumpadEnter')) {
            return e.preventDefault();
        }

        if (e.code === 'Escape') {
            return searchReset(element, $table, $trs);
        }

        if (e.type !== 'input') {
            return;
        }

        const value = element.value.toLowerCase().trim();

        if (!value.length) {
            return searchReset(element, $table, $trs);
        }

        $table.dispatchEvent(new CustomEvent('search', { detail: value }));

        const search = value.split(' ');

        $trs.forEach(element => {
            element.dataset.tableSearchValue = element.dataset.tableSearchValue || contentValue(element);

            const value = element.dataset.tableSearchValue;
            let found = 0;

            search.forEach(text => found += (value.indexOf(text) > -1) ? 1 : 0);

            element.style.display = (found === search.length) ? 'table-row' : 'none';
        });
    };

    const searchReset = function (element, $table, $trs) {
        element.value = '';

        $trs.forEach(element => {
            element.style.display = (element.dataset.tablePaginationHidden === 'true') ? 'none' : 'table-row';
        });

        $table.dispatchEvent(new CustomEvent('search', { detail: '' }));
    };

    const contentValue = function ($tr) {
        return ($tr.textContent || $tr.innerText)
            .toLowerCase()
            .replace(/(\n|\r|\s)+/gm, ' ')
            .trim();
    }

    const load = function (element) {
        if (element.dataset.tableSortLoaded || element.dataset.skipEventBinding) {
            return;
        }

        element.dataset.tableSortLoaded = true;

        const $table = document.querySelector(element.dataset.tableSearch);

        if (!$table) {
            return;
        }

        const $trs = $table.querySelectorAll('tbody > tr');

        if (!$trs.length) {
            return;
        }

        element.addEventListener('input', (e) => search(e, element, $table, $trs));
        element.addEventListener('keydown', (e) => search(e, element, $table, $trs));
    }

    const init = function () {
        document.querySelectorAll('[data-table-search]').forEach(load);
    }

    document.addEventListener('ajax', init);

    init();
})();
