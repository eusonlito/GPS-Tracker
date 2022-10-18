(function () {
    'use strict';

    function cellValue ($td) {
        return $td.dataset.tableSortValue || ($td.innerText || $td.textContent).trim();
    }

    function sort ($table, col, reverse) {
        let $body = $table.tBodies[0],
            $trs = Array.prototype.slice.call($body.rows, 0);

        reverse = -((+reverse) || -1);

        $trs = $trs.sort(function ($a, $b) {
            const aValue = cellValue($a.cells[col]);
            const bValue = cellValue($b.cells[col]);

            if (!isNaN(aValue) && !isNaN(bValue)) {
                return reverse * (aValue - bValue);
            }

            return reverse * aValue.localeCompare(bValue);
        });

        for (let i = 0; i < $trs.length; ++i) {
            $body.appendChild($trs[i]);
        }

        $table.dispatchEvent(new Event('sort'));
    }

    function load(element) {
        if (element.dataset.tableSortLoaded) {
            return;
        }

        const $ths = element.tHead.rows[0].cells;
        let i = $ths.length;

        while (--i >= 0) (function (i) {
            let dir = 1;

            $ths[i].addEventListener('click', function () {
                sort(element, i, (dir = 1 - dir));
            });
        }(i));

        element.dataset.tableSortLoaded = true;
    }

    function init () {
        document.querySelectorAll('[data-table-sort]').forEach(load);
    }

    document.addEventListener('ajax', init);

    init();
})();
