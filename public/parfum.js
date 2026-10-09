(() => {
    const formatPrice = (amount) => `Rp${new Intl.NumberFormat('id-ID').format(amount)}`;
    const updateFormPrice = (form) => {
        const selectedSprays = form.querySelector('input[name="sprays"]:checked');
        const quantity = form.querySelector('input[name="quantity"]');
        const price = form.querySelector('[data-selected-price]');
        if (!selectedSprays || !quantity || !price) return;

        const unitPrice = Number(form.dataset.pricePerSpray);
        const sprayCount = Number(selectedSprays.value);
        const itemCount = Number(quantity.value);
        price.textContent = formatPrice(unitPrice * sprayCount * itemCount);
    };

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-quantity-step]');
        if (!button) return;

        const input = button.closest('[data-quantity-control]')?.querySelector('input[type="number"]');
        if (!input) return;

        const min = Number(input.min || 0);
        const max = Number(input.max || 10);
        input.value = String(Math.min(max, Math.max(min, Number(input.value || 0) + Number(button.dataset.quantityStep))));
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    });

    document.querySelectorAll('[data-spray-form]').forEach((form) => {
        const revealButton = form.querySelector('[data-show-spray-details]');
        const details = form.querySelector('[data-spray-details]');

        revealButton?.addEventListener('click', () => {
            details.hidden = false;
            revealButton.hidden = true;
        });

        form.addEventListener('input', () => updateFormPrice(form));
        form.addEventListener('change', (event) => {
            if (event.target.name === 'sprays') {
                form.querySelectorAll('.spray-option').forEach((option) => {
                    option.classList.toggle('selected', option.querySelector('input').checked);
                });
            }
            updateFormPrice(form);
        });
        updateFormPrice(form);
    });
})();
