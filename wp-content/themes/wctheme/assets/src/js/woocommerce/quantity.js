const execute = () => {
    document.addEventListener('click', (event) => {
        let element = event.target;

        if (element.classList.contains('quantity__button--plus') || element.classList.contains('quantity__button--minus')) {
            const updateButton = document.querySelector('button[name="update_cart"]');

            let qtyInputName = element.getAttribute('data-input');
            let qtyInputs    = document.querySelectorAll(`input[name="${qtyInputName}"]`);

            qtyInputs.forEach(qtyInput => {
                let max  = parseFloat(qtyInput.getAttribute('max'));
                let min  = parseFloat(qtyInput.getAttribute('min'));
                let step = parseFloat(qtyInput.getAttribute('step'));

                let val = parseFloat(qtyInput.value);

                if (element.classList.contains('quantity__button--plus')) {
                    if (val === max) return false;
                    if (val + step > max) {
                        qtyInput.value = max;
                    } else {
                        qtyInput.value = (val + step);
                    }
                } else if (element.classList.contains('quantity__button--minus')) {
                    if (val === min) return false;
                    if (val + step < min) {
                        qtyInput.value = min;
                    } else {
                        qtyInput.value = (val - step);
                    }
                }
            })

            updateButton.disabled = false;
            updateButton.click();
        }
    });

    jQuery(document).on('change', '#woocommerce-cart-form input.qty', function(){

        const updateButton = document.querySelector('button[name="update_cart"]');

        let name     = jQuery(this).attr('name');
        let val      = jQuery(this).val();
        jQuery('input[name="'+name+'"]').val(val);

        updateButton.disabled = false;
        updateButton.click();

    });

}

export default execute;