import Ajax from './ajax';

(function () {
    'use strict';

    const element = document.querySelector('[data-maintenance-update-item]');
    const modal = document.getElementById('update-item-modal');

    if (!element || !modal) {
        return;
    }

    let moneySymbol;
    let numberFormatLocale;

    const float = (value) => parseFloat(value || 0);
    const amount = (value) => Math.max(0, value).toFixed(2);

    const money = (value) => {
        return moneySymbol.replace('NUMBER', new Intl.NumberFormat(numberFormatLocale).format(value));
    }

    const setMoneyConversion = (value) => {
        if (numberFormatLocale) {
            return;
        }

        numberFormatLocale = value.includes(',') ? 'es-ES' : 'en-US';
        moneySymbol = value.replace(/[0-9,\.]+/g, 'NUMBER');
    };

    const events = () => {
        element.querySelectorAll('[data-maintenance-update-item-maintenance_item_id]').forEach(selectListener);

        element.querySelectorAll('[data-maintenance-update-item-quantity]').forEach(inputListener);
        element.querySelectorAll('[data-maintenance-update-item-amount_gross]').forEach(inputListener);
        element.querySelectorAll('[data-maintenance-update-item-tax_percent]').forEach(inputListener);

        element.querySelectorAll('[data-maintenance-update-item-add]').forEach(buttonAddListener);
        element.querySelectorAll('[data-maintenance-update-item-remove]').forEach(buttonRemoveListener);

        modalFormListener();
    };

    const inputListener = (input) => {
        input.removeEventListener('keyup', inputHandler);
        input.addEventListener('keyup', inputHandler);
    };

    const inputHandler = (e) => {
        const tr = e.target.closest('tr');

        const quantity_value = float(tr.querySelector('[data-maintenance-update-item-quantity]').value);
        const amount_gross_value = float(tr.querySelector('[data-maintenance-update-item-amount_gross]').value);
        const tax_percent_value = float(tr.querySelector('[data-maintenance-update-item-tax_percent]').value);

        const amount_net = tr.querySelector('[data-maintenance-update-item-amount_net]');
        const tax_amount = tr.querySelector('[data-maintenance-update-item-tax_amount]');
        const subtotal = tr.querySelector('[data-maintenance-update-item-subtotal]');
        const total = tr.querySelector('[data-maintenance-update-item-total]');

        const amount_net_value = amount_gross_value * (1 + tax_percent_value / 100);
        const subtotal_value = quantity_value * amount_gross_value;
        const tax_amount_value = subtotal_value * tax_percent_value / 100;
        const total_value = subtotal_value + tax_amount_value;

        amount_net.value = amount(amount_net_value);
        subtotal.value = amount(subtotal_value);
        tax_amount.value = amount(tax_amount_value);
        total.value = amount(total_value);

        totals(tr);
    };

    const totals = (tr) => {
        const table = tr.closest('table');
        const values = {};

        table.querySelectorAll('input[type="number"]').forEach(input => {
            const name = input.name.replace('[]', '');

            if (!values[name]) {
                values[name] = [];
            }

            values[name].push(float(input.value));
        });

        values.quantity = values.quantity.reduce((sum, a) => sum + a, 0);
        values.amount_gross = values.amount_gross.reduce((sum, a) => sum + a, 0);
        values.amount_net = values.amount_net.reduce((sum, a) => sum + a, 0);
        values.subtotal = values.subtotal.reduce((sum, a) => sum + a, 0);
        values.tax_amount = values.tax_amount.reduce((sum, a) => sum + a, 0);
        values.total = values.total.reduce((sum, a) => sum + a, 0);

        const tfoot = table.querySelector('tfoot');

        setMoneyConversion(tfoot.querySelector('[data-maintenance-update-item-total-total]').innerText);

        tfoot.querySelector('[data-maintenance-update-item-total-quantity]').innerText = values.quantity;
        tfoot.querySelector('[data-maintenance-update-item-total-amount_gross]').innerText = money(values.amount_gross);
        tfoot.querySelector('[data-maintenance-update-item-total-amount_net]').innerText = money(values.amount_net);
        tfoot.querySelector('[data-maintenance-update-item-total-subtotal]').innerText = money(values.subtotal);
        tfoot.querySelector('[data-maintenance-update-item-total-tax_amount]').innerText = money(values.tax_amount);
        tfoot.querySelector('[data-maintenance-update-item-total-total]').innerText = money(values.total);
    };

    let maintenanceItemIdSelected;

    const selectListener = (select) => {
        select.removeEventListener('change', selectHandler);
        select.addEventListener('change', selectHandler);
    };

    const selectHandler = (e) => {
        maintenanceItemIdSelected = e.target;

        if (maintenanceItemIdSelected.value !== '0') {
            return;
        }

        maintenanceItemIdSelected.value = '';

        modal.show();
    };

    const modalForm = modal.querySelector('form');
    const language = navigator.language || navigator.userLanguage;
    const comparator = new Intl.Collator(language.slice(0, 2)).compare;

    const modalFormHandlerCallback = (response) => {
        element.querySelectorAll('[data-maintenance-update-item-maintenance_item_id]').forEach(select => {
            const option = document.createElement('option');

            option.value = response.id;
            option.innerHTML = response.name;

            select.insertBefore(option, select.lastElementChild);

            const options = Array.from(select.children);

            options.sort((a, b) => {
                if (a.value === '0') {
                    return 1;
                }

                if (b.value === '0') {
                    return -1;
                }

                if (a.value === '') {
                    return -1;
                }

                if (b.value === '') {
                    return 1;
                }

                return comparator(a.textContent, b.textContent)
            });

            options.forEach((option) => select.appendChild(option));
        });

        maintenanceItemIdSelected.value = response.id;

        modalForm.querySelector('input[type="text"]').value = '';

        modal.hide();
    };

    const modalFormHandlerErrorCallback = (response) => {
       window.alert(response.message);
    };

    const modalFormHandler = (e) => {
        e.preventDefault();

        new Ajax(modalForm.action, 'POST')
            .setBodyForm(modalForm)
            .setJson(false)
            .setJsonResponse(true)
            .setCallback(modalFormHandlerCallback)
            .setErrorCallback(modalFormHandlerErrorCallback)
            .send();
    };

    const modalFormListener = () => {
        modalForm.removeEventListener('submit', modalFormHandler);
        modalForm.addEventListener('submit', modalFormHandler);
    };

    const buttonAddListener = (button) => {
        button.removeEventListener('click', buttonAddHandler);
        button.addEventListener('click', buttonAddHandler);
    };

    const templateClone = (tr) => {
        const clone = element.querySelector('[data-maintenance-update-item-template]').cloneNode(true);

        delete clone.dataset.maintenanceUpdateItemTemplate;

        clone.classList.remove('hidden');

        tr.parentNode.insertBefore(clone, tr.nextSibling);

        events();
    };

    const buttonAddHandler = (e) => {
        e.preventDefault();

        templateClone(e.target.closest('tr'));
    };

    const buttonRemoveListener = (button) => {
        button.removeEventListener('click', buttonRemoveHandler);
        button.addEventListener('click', buttonRemoveHandler);
    };

    const buttonRemoveHandler = (e) => {
        e.preventDefault();

        const tr = e.target.closest('tr');

        if (tr.closest('tbody').childElementCount < 3) {
            templateClone(tr);
        }

        tr.remove();
    };

    events();
})();
