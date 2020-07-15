export function addEventListener(el, eventName, handler) {
    if (el.addEventListener) {
        el.addEventListener(eventName, handler);
    } else {
        el.attachEvent('on' + eventName, function() {
            handler.call(el);
        });
    }
}

export function triggerEvent(el, eventName, options) {
    let event;
    if (window.CustomEvent) {
        event = new CustomEvent(eventName, options);
    } else {
        event = document.createEvent('CustomEvent');
        event.initCustomEvent(eventName, true, true, options);
    }
    return el.dispatchEvent(event);
}

export function setCookie(name, value, minutes) {
    let expires;

    if (minutes) {
        const date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }

    document.cookie = name + "=" + value + expires + "; path=/";
}

export function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

export function deleteCookie(name) {
    setCookie(name, "", -1);
}

export function changeWoocommerceStep(nextStep, previousStep) {
    const currentStep = document.querySelector(`[data-step="${nextStep}"]`)
    const prevStep = document.querySelector(`[data-step="${previousStep}"]`)

    if (currentStep && prevStep) {
        currentStep.classList.add('steps__step--active')
        prevStep.classList.remove('steps__step--active')
        prevStep.classList.add('steps__step--done')

        jQuery('.woocommerce-notices-wrapper').empty();

        let prevStepImg = prevStep.querySelector('img')
        prevStepImg.src = prevStepImg.src.replace(previousStep, 'done')
    }
}

jQuery('.center-dropdown-menu li').hover(function() {
    const dataTermValue = jQuery(this).attr('data-term');
    jQuery('.submenu_image_right').hide();
    jQuery('.img-container img[data-term=' + dataTermValue + ']').toggleClass('showImg');
}, function() {
    jQuery('.submenu_image_right').show();
    jQuery('.img-container img[data-term]').removeClass('showImg');
});

jQuery('.search-link').click(function() {
    jQuery('.search-container').addClass('search-container--open');
});

jQuery('.search-container__close').click(function() {
    jQuery('.search-container').removeClass('search-container--open');
});


(function($) {

    // Set favorites products cookie if not exists
    if ( !getCookie('favoritesProducts') ) {
        setCookie('favoritesProducts', '', '525600');
    }

    $('.order__heading [data-collapse]').on('click', function() {
        $(this).parents('tr').toggleClass('active');
    });

    $('.menu-item-has-children span.arrow').on('click', function(e){
        e.preventDefault();
        $(this).parent().next().toggle();
    });

    $(document).on('click', '.cwginstock-subscribe-form h4', function(){
        $('.cwginstock-panel-body').slideToggle();
    });

    // Save favorite product in cookies
    $(document).on('click', '.favourites', function(e) {

        var _this                   = $(this),
            productId               = _this.attr('data-id'),
            favoritesProducts       = getCookie('favoritesProducts'),
            favoritesProducts       = favoritesProducts ? favoritesProducts.split(',') : [];

            if ( !_this.hasClass('favourites-added') ) {

                _this.find('.empty-heart').addClass('full-heart');

                if ( !favoritesProducts.includes(productId) ) {
                    favoritesProducts.push(productId);
                    setCookie('favoritesProducts', favoritesProducts.toString(), '525600' );
                }

            } else {

                _this.find('.empty-heart').removeClass('full-heart');
                
                if ( favoritesProducts.includes(productId) ) {
                    
                    var index = favoritesProducts.indexOf(productId);
                    if ( index !== -1 ) favoritesProducts.splice(index, 1);

                    setCookie('favoritesProducts', favoritesProducts.toString(), '525600' );
                }                

            }

            _this.toggleClass('favourites-added');

    });

})(jQuery);

// Gallery carousel 3d
if (jQuery('#gallery__carousel').length > 0) {
    var galleryCarousel = jQuery('#gallery__carousel').waterwheelCarousel({
        'activeClassName': 'active',
        'separation': 355,
        'horizonOffset': 0,
        'forcedImageWidth': 425,
        'forcedImageHeight': 280,
        'flankingItems': 5,
        'sizeMultiplier': 0.5
    });

    jQuery('.gallery__carousel__nav--next').on('click', function(e) {
        e.preventDefault();
        galleryCarousel.next();
    });

    jQuery('.gallery__carousel__nav--prev').on('click', function(e) {
        e.preventDefault();
        galleryCarousel.prev();
    });

}

// Show hide alert email
jQuery('.subscribe_for_interest_text').on('click', function() {
    jQuery('.notify__email').attr('style', 'display: block');
});

jQuery('.stock_alert_button, .stock_alert_email').wrapAll('<div class="notify__email">');

jQuery('.stock_alert_button').on('click', function() {
    jQuery('.stock_alert_email').wrapAll('<div class="notify__email">');
});

// Fb news share
export function fbShare(url, title, descr) {
    var windowHeight = 350,
        windowWidth = 520,  
        alignTop = (screen.height / 2) - (windowHeight / 2),
        alignLeft = (screen.width / 2) - (windowWidth / 2),
        facebookShareUrl = 'https://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url
  
    window.open( facebookShareUrl, "","top=" + alignTop + ",left=" + alignLeft + ",width=" + windowWidth +",height=" + windowHeight);

}

jQuery('.fb__share a').on('click', function(e) {

    e.preventDefault();
    let _title          = jQuery(this).parent().attr('data-title'),
        _url            = jQuery(this).parent().attr('data-url'),
        _description    = jQuery(this).parent().attr('data-description');

    fbShare( _url, _title, _description );

});

// Remove empty paragraphs
jQuery('p').each(function() {
    var $this = jQuery(this);
    if( $this.html().replace(/\s|&nbsp;/g, '').length == 0 ) {
        $this.remove();
    }
});

// 404 page history back
if ( window.history.length > 1 ) {
    jQuery('.historyBack').on('click', function() {
        window.history.go(-1); 
        return false;
    });
} else {
    jQuery('.section__404--content__links--back').hide();
}

// Trigger click on product image - go to product details
jQuery('.product__overlay--full').click(function(e) {
    
    var _this = jQuery(this),
        _link = _this.find('.product__functional-buttons a').attr('href');

    if ( jQuery(e.target).is('.product__ekstra-info') || jQuery(e.target).is('.product__overlay')  ) {
        window.location.href = _link;
    }

});
