(function () {
    'use strict';

    const float = (value) => parseFloat(value || 0);
    const amount = (value) => Math.max(0, value).toFixed(2);

    const total = (first, second) => amount(float(first) * float(second));
    const subtract = (first, second) => amount(float(first) - float(second));
    const divide = (first, second) => amount(float(first) / float(second));

    document.querySelectorAll('[data-calculator-total]').forEach(element => {
        const first = document.querySelector(element.dataset.calculatorTotalFirst);
        const second = document.querySelector(element.dataset.calculatorTotalSecond);

        if (!first || !second) {
            return;
        }

        const handler = (e) => {
            if (!e.isTrusted) {
                return;
            }

            if (e.target === element) {
                first.value = divide(element.value, second.value)
            } else {
                element.value = total(first.value, second.value)
            }
        }

        first.addEventListener('keyup', handler);
        second.addEventListener('keyup', handler);
        element.addEventListener('keyup', handler);
    });

    document.querySelectorAll('[data-calculator-difference]').forEach(element => {
        const target = document.querySelector(element.dataset.calculatorDifference);

        if (!target) {
            return;
        }

        const handler = (e) => {
            if (!e.isTrusted) {
                return;
            }

            element.value = subtract(target.value, element.dataset.calculatorDifferenceValue);
        }

        element.dataset.calculatorDifferenceValue = target.value;

        target.addEventListener('keyup', handler);
    });
})();
