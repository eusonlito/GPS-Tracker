(function () {
    'use strict';

    function icon(name) {
        return '<svg class="feather s-20px"><use xlink:href="' + window.location.origin + '/build/images/feather-sprite.svg#' + name + '" /></svg>';
    }

    function create($table, total, limit) {
        const $paginator = paginator($table);
        const pages = parseInt((total / limit) + (((total % limit) === 0) ? 0 : 1));

        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="first">' + icon('chevrons-left') + '</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="previous">' + icon('chevron-left') + '</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link pagination__link--active whitespace-nowrap" data-table-pagination-navigate="current" data-table-pagination-page="1"></a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="next">' + icon('chevron-right') + '</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="last">' + icon('chevrons-right') + '</a></li>');

        paginate($table, $paginator, $paginator.querySelector('[data-table-pagination-navigate="current"]'));

        $paginator.querySelectorAll('a').forEach(each => each.addEventListener('click', () => paginate($table, $paginator, each, true), false));

        $table.addEventListener('search', (e) => event(e, $table, $paginator), false);
        $table.addEventListener('sort', (e) => event(e, $table, $paginator), false);
    }

    function paginator($table) {
        if ($table.dataset.tablePagination.length) {
            return document.getElementById($table.dataset.tablePagination);
        }

        const $paginator = document.createElement('ul');

        $paginator.id = $table.id + '-pagination';
        $paginator.classList.add('pagination', 'justify-end');

        $table.parentNode.insertBefore($paginator, $table.nextSibling);

        return $paginator;
    }

    function paginate($table, $paginator, $page, click) {
        if ((click === true) && $page.dataset.tablePaginationPage) {
            paginateAll($table, $paginator, $page);
        } else {
            paginatePages($table, $paginator, $page);
        }
    }

    function paginatePages($table, $paginator, $page) {
        const limit = parseInt($table.dataset.tablePaginationLimit || 20);
        const $trs = $table.querySelectorAll('tbody > tr');
        const $current = $paginator.querySelector('[data-table-pagination-navigate="current"]');

        const total = $trs.length;
        const pages = parseInt((total / limit) + (((total % limit) === 0) ? 0 : 1));
        const action = $page.dataset.tablePaginationNavigate;

        let page = parseInt($current.dataset.tablePaginationPage);

        if (action === 'first') {
            page = 1;
        } else if (action === 'previous') {
            page = page - 1;
        } else if (action === 'next') {
            page = page + 1;
        } else if (action === 'last') {
            page = pages;
        }

        page = (page < 1) ? 1 : ((page > pages) ? pages : page);

        const first = (page - 1) * limit;
        const last = (page * limit) - 1;

        $trs.forEach(function (value, index) {
            const $tr = $trs[index];

            if ((index < first) || (index > last)) {
                $tr.style.display = 'none';
                $tr.dataset.tablePaginationHidden = 'true';
            } else {
                $tr.style.display = 'table-row';
                $tr.dataset.tablePaginationHidden = 'false';
            }
        });

        $current.dataset.tablePaginationPage = page;
        $current.innerHTML = page + ' / ' + pages + '&nbsp;&nbsp;&nbsp;&boxH;&nbsp;&nbsp;&nbsp;' + total;
    }

    function paginateAll($table, $paginator, $page) {
        if ($page.dataset.tablePaginationShowAll) {
            $page.dataset.tablePaginationShowAll = '';

            return paginatePages($table, $paginator, $page);
        }

        const $trs = $table.querySelectorAll('tbody > tr');
        const total = $trs.length;

        $trs.forEach(function (value, index) {
            const $tr = $trs[index];

            $tr.style.display = 'table-row';
            $tr.dataset.tablePaginationHidden = 'false';
        });

        $page.innerHTML = total;
        $page.dataset.tablePaginationShowAll = 'true';
    }

    function reset($table, $paginator) {
        paginate($table, $paginator, $paginator.querySelector('[data-table-pagination-navigate="current"]'));
    }

    function event(e, $table, $paginator) {
        switch (e.type) {
            case 'sort':
                return eventSort(e, $table, $paginator);

            case 'search':
                return eventSearch(e, $table, $paginator);
        }
    }

    function eventSort(e, $table, $paginator) {
        return reset($table, $paginator);
    }

    function eventSearch(e, $table, $paginator) {
        if (e.detail) {
            return $paginator.classList.add('hidden');
        }

        $paginator.classList.remove('hidden');

        return reset($table, $paginator);
    }

    function load(element) {
        if (element.dataset.tablePaginationLoaded) {
            return;
        }

        const total = element.querySelectorAll('tbody > tr').length;
        const limit = parseInt(element.dataset.tablePaginationLimit || 20);

        if (total > limit) {
            create(element, total, limit);
        }

        element.style.display = 'table';

        element.dataset.tablePaginationLoaded = true;
    }

    function init () {
        document.querySelectorAll('[data-table-pagination]').forEach(load);
    }

    document.addEventListener('ajax', init);

    init();
})();
