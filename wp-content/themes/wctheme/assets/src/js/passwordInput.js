const execute = () => {
    const buttons = document.querySelectorAll('button[data-event="showPassword"]');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            let inputID   = button.getAttribute('data-input');
            let input     = document.getElementById(inputID);
            let inputType = input.getAttribute('type');

            if (inputType === 'password') {
                input.setAttribute('type', 'text');
            } else {
                input.setAttribute('type', 'password');
            }
        });
    })
}

export default execute;