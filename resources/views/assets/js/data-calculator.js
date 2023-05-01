(function () {
    'use strict';

    const total = function (first, second) {
        return Math.max(0, parseFloat(first || 0) * parseFloat(second || 0)).toFixed(2);
    };

    const subtract = function (first, second) {
        return Math.max(0, parseFloat(first || 0) - parseFloat(second || 0)).toFixed(2);
    };

    document.querySelectorAll('[data-calculator-total]').forEach(element => {
        const first = document.querySelector(element.dataset.calculatorTotalFirst);
        const second = document.querySelector(element.dataset.calculatorTotalSecond);

        if (!first || !second) {
            return;
        }

        first.addEventListener('keyup', (e) => element.value = total(first.value, second.value));
        second.addEventListener('keyup', (e) => element.value = total(first.value, second.value));
    });

    document.querySelectorAll('[data-calculator-difference]').forEach(element => {
        const target = document.querySelector(element.dataset.calculatorDifference);

        if (!target) {
            return;
        }

        element.dataset.calculatorDifferenceValue = target.value;

        target.addEventListener('keyup', (e) => element.value = subtract(target.value, element.dataset.calculatorDifferenceValue));
    });
})();
