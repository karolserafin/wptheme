import moment from 'moment';
import flatpickr from 'flatpickr';
import { triggerEvent, changeWoocommerceStep, getCookie, setCookie } from "../utils";

const Polish = require('flatpickr/dist/l10n/pl.js').default.pl;

const execute                = () => {
    const shippingRadio       = document.querySelectorAll('input.shipping_method');
    const locationRadio       = document.querySelectorAll('input[name="location"]');
    const userRadio           = document.querySelectorAll('input[name="user_type"]');
    const paymentsRadio       = document.querySelectorAll('input[name="payment_method"]');
    const userType            = document.querySelectorAll('input[name="user_type"]');
    const postalCodeInput     = document.querySelector('input[name="postal_code"]');
    const billingPostalCode   = document.querySelector('input[name="billing_postcode"]');
    //const shippingPostalCode  = document.querySelector('input[name="shipping_postcode"]');
    const checkoutCoupon      = document.querySelector('input[name="coupon"]');
    const companyName         = document.querySelector('input[name="billing_company"]');
    const companyNip          = document.querySelector('input[name="billing_nip"]');
    const checkoutCouponBtn   = document.querySelector('button[name="add_coupon"]');
    const coupon              = document.querySelector('input[name="coupon_code"]');
    const couponBtn           = document.querySelector('button[name="apply_coupon"]');
    const registerButton      = document.querySelector('#register-button');
    const guestButton         = document.querySelector('#guest-button');
    const stepContentShipping = document.querySelector('.step__content--shipping');
    const stepContentLogin    = document.querySelector('.step__content--login');
    const calendarConfig      = document.getElementById('calendar');
    const now                 = moment();
    let init = false;
    let currentOpeningTime;
    let disabledDates;
    let currentShippingMethod;
    moment.locale('pl');

    // if (getCookie('checkout_step') === '3') {
    //     changeWoocommerceStep('shipping', 'login')
    // }
    // if (getCookie('checkout_step') === '3-register') {
    //     changeWoocommerceStep('shipping', 'login')
    //     const createAccount = document.querySelector('input[name="createaccount"]')
    //     createAccount.setAttribute('checked', 'checked')
    //     jQuery('.shipping__account').slideDown()
    // }

    // DatePicker config
    let minDate          = now.hour() < 18 ? new Date().fp_incr(1) : new Date().fp_incr(2);
    let datePickerConfig = {
        inline: true,
        dateFormat: 'd-m-Y',
        monthSelectorType: 'static',
        yearSelectorType: 'static',
        defaultDate: 'today',
        minDate: calendarConfig.getAttribute('data-delayed') ? new Date().fp_incr(5) : minDate,
        locale: Polish,

        onChange: (selectedDates) => {
            if (!currentShippingMethod.includes('pickpack') && currentOpeningTime) {
                fillTimeSelect(currentOpeningTime.availability[moment(selectedDates[0]).isoWeekday() - 1].range);
            }

            if (selectedDates) {
                triggerEvent(document.body, 'update_checkout')
            }
        }
    };
    const datePicker     = flatpickr('input[name="shipping_date"]', datePickerConfig);

    // Functions
    const clearCalendar                = () => {
        datePicker.clear();
        datePicker.set('disable', []);
        datePicker.set('minDate', calendarConfig.getAttribute('data-delayed') ? new Date().fp_incr(5) : minDate);
        datePicker.set('maxDate', '');
    }
    const configCalendarForLocalPickup = (inputValue) => {
        currentOpeningTime = getLocationOpeningTime(inputValue);
        disabledDates      = getDisabledDates(currentOpeningTime.availability);
        datePicker.set('disable', [
            function (date) {
                return disabledDates && disabledDates.includes(moment(date).isoWeekday() - 1)
            }
        ])
        if (currentOpeningTime.is_new && currentOpeningTime.days_range) {
            let dateTo   = '';
            let dateFrom = minDate;

            if (currentOpeningTime.days_range.date_from) {
                let openingFrom = moment(currentOpeningTime.days_range.date_from);
                dateFrom        = openingFrom > minDate ? openingFrom.toDate() : minDate;
            }

            if (currentOpeningTime.days_range.date_to) {
                dateTo = moment(currentOpeningTime.days_range.date_to).toDate();
            }

            datePicker.set('minDate', dateFrom);
            datePicker.set('maxDate', dateTo);
        }
    }

    const handleLocationRadioChange        = event => {
        clearCalendar();
        clearTimeSelect();
        configCalendarForLocalPickup(event.target.value);

        hideTimeRangeSelectForNewLocation(event.target.getAttribute('data-new'));
        triggerEvent(document.body, 'updated_checkout');
    };
    const initCalendarConfigForLocalPickup = () => {
        locationRadio.forEach(radio => {
            if (radio.checked) {
                configCalendarForLocalPickup(radio.value)
            }

            radio.removeEventListener('change', handleLocationRadioChange);
            radio.addEventListener('change', handleLocationRadioChange);
        })
    }

    const changeUserFieldsVisibility = (val) => {
        if ( val == 'company' ) {
            jQuery('.checkout-company, .checkout-nip').removeClass('uk-hidden');
        } else {
            jQuery('.checkout-company, .checkout-nip').addClass('uk-hidden');
        }
    }

    initCalendarConfigForLocalPickup();

    document.addEventListener('click', (event) => {
        let element = event.target;

        if (element.classList.contains('shipping_method')) {
            let inputValue = element.value;

            clearCalendar();
            changeVisibilityForShippingElements(inputValue);
        }
    });

    userRadio.forEach(radio => {
        radio.addEventListener('change', (event) => {
            changeUserFieldsVisibility(event.target.value);
        });
    });

    shippingRadio.forEach(radio => {
        if (radio.checked) {
            changeVisibilityForShippingElements(radio.value);
            currentShippingMethod = radio.value;
        }

        radio.addEventListener('change', (event) => {
            clearCalendar();
            clearTimeSelect();
            jQuery('input[name="postal_code"]').val('');
            currentShippingMethod = event.target.value;
            jQuery('.woocommerce-checkout').submit();
            jQuery('.woocommerce-NoticeGroup-checkout').empty();

            if (event.target.value.includes('local_pickup')) {
                initCalendarConfigForLocalPickup();
            }

        });
    });

    paymentsRadio.forEach(radio => {
        radio.addEventListener('change', (event) => {
            let inputValue = event.target.value;

            jQuery('.options').slideUp();
            jQuery('.options[data-payment="'+inputValue+'"]').slideDown();
        });

    });

    checkoutCouponBtn.addEventListener('click', () => {
        coupon.value = checkoutCoupon.value;
        jQuery(couponBtn).trigger('click')
        jQuery('#coupon-form-to-submit').slideDown()
        jQuery.scroll_to_notices( jQuery('#coupon-form-to-submit') )
    })

    postalCodeInput.addEventListener('input', () => {
        if ( postalCodeInput.value.length === 6 ) {
            billingPostalCode.value = postalCodeInput.value;
            init = true;
            jQuery('.checkout__postcode__info').fadeIn();
            //triggerEvent(document.body, 'update_checkout');
            triggerEvent(document.body, 'update_checkout');
            //jQuery('.woocommerce-checkout').submit();
        }
    });

    userType.forEach(radio => {
        radio.addEventListener('change', (event) => {
            let inputValue = event.target.value;

            console.log(inputValue);

            if ( inputValue == 'company' ) {
                if ( companyName.value == '' || companyNip.value == '' ) {
                    jQuery('p#billing_company_field, p#billing_nip_field').addClass('error');
                } else {
                    jQuery('p#billing_company_field, p#billing_nip_field').removeClass('error');
                }
            }

        });

    });

    billingPostalCode.addEventListener('change', () => {
        postalCodeInput.value = billingPostalCode.value;
        triggerEvent(document.body, 'updated_checkout');
    });
    // shippingPostalCode.addEventListener('change', () => {
    //     postalCodeInput.value = shippingPostalCode.value;
    //     triggerEvent(document.body, 'update_checkout')
    // });

    jQuery(document.body).on('updated_checkout', function () {

        jQuery('.checkout__postcode__info').fadeOut();
        jQuery('#checkout-validator').val('true');

        const shippingRadio        = document.querySelectorAll('input.shipping_method');
        const checkedShippingRadio = document.querySelectorAll('input.shipping_method:checked');

        if ( init ) {
            jQuery('.shipping__options, .shipping__local-pickup, .shipping__calendar, .shipping__time').removeClass('uk-hidden');
        }

        if ( !postalCodeInput.value.length ) {
            jQuery('input[name="postal_code"]').addClass('error');
        } else {
            jQuery('input[name="postal_code"]').removeClass('error');
        }

        shippingRadio.forEach(radio => {
            if (radio.checked) {
                changeVisibilityForShippingElements(radio.value);
                currentShippingMethod = radio.value;
            }

            radio.addEventListener('change', (event) => {
                clearCalendar();
                clearTimeSelect();
                currentShippingMethod = event.target.value;
                jQuery('.woocommerce-checkout').submit();
                jQuery('.woocommerce-NoticeGroup-checkout').empty();

                if (event.target.value.includes('local_pickup')) {
                    initCalendarConfigForLocalPickup();
                }
            })
        });

    });

    registerButton.addEventListener('click', () => {
        stepContentLogin.classList.remove('step__content--active')
        stepContentShipping.classList.add('step__content--active')
        const createAccount = document.querySelector('input[name="createaccount"]')
        createAccount.setAttribute('checked', 'checked')
        jQuery('.shipping__account').slideDown()
        changeWoocommerceStep('shipping', 'login')

        // setCookie('checkout_step', '3-register', 20)
    })
    guestButton.addEventListener('click', () => {
        stepContentLogin.classList.remove('step__content--active')
        stepContentShipping.classList.add('step__content--active')
        changeWoocommerceStep('shipping', 'login')

        // setCookie('checkout_step', '3', 20)
    })

    window.addEventListener('keydown', function (e) {
        if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
            if (e.target.nodeName == 'INPUT' && e.target.type == 'text' && e.target.id == 'postal_code') {
                triggerEvent(document.body, 'updated_checkout')
                e.preventDefault();
                return false;
            } else if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                e.preventDefault();
                return false;
            }
        }
    }, true);
}
let locationOpeningTimeCache = {};

const getLocationOpeningTime = (location_id) => {
    let result = false;

    if (locationOpeningTimeCache.hasOwnProperty(location_id)) {
        return locationOpeningTimeCache[location_id];
    }

    jQuery.ajax({
        type: 'post',
        dataType: 'json',
        url: ajaxurl,
        async: false,
        data: {
            action: 'wctheme_get_location_opening_time',
            location_id: location_id,
        },
        success: (response) => {
            result = response;
        }
    });

    locationOpeningTimeCache[location_id] = result;

    return result;
}

const getPickPackTimeRange = () => {
    let result = false;

    jQuery.ajax({
        type: 'post',
        dataType: 'json',
        url: ajaxurl,
        async: false,
        data: {
            action: 'wctheme_get_pickpack_time_range',
        },
        success: (response) => {
            result = response;
        }
    });

    return result;
}

const getDisabledDates = (dates) => {
    return Object.keys(dates)
        .filter(key => dates[key].is_open === false)
        .reduce((obj, key) => {
            obj.push(parseInt(key));
            return obj;
        }, []);
}

const fillTimeSelect = (dates) => {
    let select       = document.getElementById('shipping_time');
    select.innerHTML = '';

    if (dates) {
        dates.forEach(date => {
            let opt       = document.createElement('option');
            opt.innerHTML = date;
            if (!date.includes('Wybierz'))
                opt.value = date;
            else {
                opt.disabled = true;
                opt.selected = true;
            }
            select.appendChild(opt);
        });
    }
}

const clearTimeSelect = () => {
    let select       = document.getElementById('shipping_time');
    select.innerHTML = '';
}

const changeVisibilityForShippingElements = (inputValue) => {
    
    jQuery('.checkout__delivery__info').hide();

    if (inputValue.includes('local_pickup')) {
        // jQuery('.shipping__flat-rate').hide();
        jQuery('.shipping__shipping').hide();
        jQuery('.shipping__time').slideDown();
        jQuery('.shipping__local-pickup').slideDown();
        jQuery('.shipping__calendar').slideDown();

    } else if (inputValue.includes('pickpack')) {
        const pickPackTimeRange = getPickPackTimeRange()
        fillTimeSelect(pickPackTimeRange.availability.range)
        jQuery('.shipping__local-pickup').hide();
        jQuery('.shipping__time').slideDown();
        jQuery('.shipping__shipping').slideDown();
        // jQuery('.shipping__flat-rate').slideDown();
        jQuery('.shipping__calendar').slideDown();

    } else if (inputValue.includes('wctheme_free_shipping')) {
        jQuery('.shipping__time').hide();
        jQuery('.shipping__local-pickup').hide();
        jQuery('.shipping__shipping').slideDown();
        // jQuery('.shipping__flat-rate').slideDown();
        jQuery('.shipping__calendar').slideDown();

    } else if (inputValue.includes('flat_rate')) {
        jQuery('.shipping__time').hide();
        jQuery('.shipping__local-pickup').hide();
        jQuery('.shipping__calendar').hide();
        // jQuery('.shipping__flat-rate').slideDown();
        jQuery('.shipping__shipping').slideDown();

    } else {
        jQuery('.shipping__local-pickup').hide();
        jQuery('.shipping__shipping').slideDown();
        // jQuery('.shipping__flat-rate').slideDown();
        jQuery('.shipping__time').slideDown();
        jQuery('.shipping__calendar').slideDown();
    }

    if ( inputValue.includes('pickpack:3') ) {
        jQuery('.checkout__delivery__info--zone1').slideDown();
    }

    if ( inputValue.includes('pickpack:5') ) {
        jQuery('.checkout__delivery__info--zone2').slideDown();   
    }

}

const hideTimeRangeSelectForNewLocation = (isNew) => {
    if (isNew)
        jQuery('.shipping__time').hide();
    else
        jQuery('.shipping__time').slideDown();
}

export default execute;