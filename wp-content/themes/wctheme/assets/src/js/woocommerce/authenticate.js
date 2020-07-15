import { triggerEvent } from "../utils";

const scrollTo = () => {

    setTimeout(function() {

        jQuery("html, body").animate({
            scrollTop: jQuery("body").offset().top
        }, 1000);

    }, 800);

}

const execute = () => {
    const registerButton   = document.getElementById('register-button')
    const backBtn          = document.querySelector('#go-back')
    const contentLogin     = document.querySelector('.step__content--login')
    const contentRegister  = document.querySelector('.step__content--register')
    const registerEmail    = document.querySelector('#reg_email')
    const registerUsername = document.querySelector('#reg_username')

    registerButton.addEventListener('click', () => {
        contentLogin.classList.remove('step__content--active');
        contentRegister.classList.add('step__content--active');
        scrollTo();
    })

    backBtn.addEventListener('click', () => {
        contentLogin.classList.add('step__content--active')
        contentRegister.classList.remove('step__content--active')
    })

    registerEmail.addEventListener('change', () => {
        registerUsername.value = registerEmail.value;
    });
}

export default execute