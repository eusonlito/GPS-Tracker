import Chart from 'chart.js/auto';

(function () {
    'use strict';

    if ((typeof charts === 'undefined') || !Array.isArray(charts)) {
        return;
    }

    for (var i = 0; i < charts.length; i++ ) {
        new Chart(document.getElementById(charts[i].id).getContext('2d'), charts[i].config);
    }
})();
