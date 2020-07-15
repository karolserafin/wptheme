// UIKit
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// Components
import PasswordInput from './passwordInput';

PasswordInput();

// WooCommerce Components
import Quantity from './woocommerce/quantity';
import CheckoutLocation from './woocommerce/checkoutLocation';
import MiniCart from './woocommerce/miniCart';
import Authenticate from './woocommerce/authenticate';

Quantity();
MiniCart();

if (document.querySelector('.woocommerce-account')) {
    Authenticate();
}

if (document.querySelector('form.woocommerce-checkout')) {
    CheckoutLocation();
}

// loads the Icon plugin
UIkit.use(Icons);