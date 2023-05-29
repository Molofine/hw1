function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function jsonCheckUsername(json) {
    if (!(formStatus.username = !json.exists)) {
        const error = document.querySelector('#username_error');
        error.textContent = "• Nome utente già in uso";
    }
}

function jsonCheckEmail(json) {
    if (!(formStatus.email = !json.exists)) {
        const error = document.querySelector('#email_error');
        error.textContent = "• Email già in uso";
    }
}

function checkUsername(event) {
    const inputUser = document.querySelector('input[name="username"]');

    const error = document.querySelector('#username_error');
    error.textContent = "";

    if(inputUser.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
        formStatus.username = false;
    } else if(!/^[a-zA-Z0-9_]{1,15}$/.test(inputUser.value)) {
        error.textContent = "• Formato username non corretto";
        formStatus.username = false;
    } else {
        fetch("check_username.php?q="+encodeURIComponent(inputUser.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}

function checkEmail(event) {
    const inputEmail = document.querySelector('input[name="email"]');

    const error = document.querySelector('#email_error');
    error.textContent = "";

    if(inputEmail.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
        formStatus.email = false;
    } else if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(inputEmail.value).toLowerCase())) {
        error.textContent = "• Formato email non corretta";
        formStatus.email = false;
    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(inputEmail.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }    
}

function checkConfirmEmail(event) {
    const inputConfirmEmail = document.querySelector('input[name="confirm_email"]');

    const error = document.querySelector('#confirm_email_error');
    error.textContent = "";

    if(inputConfirmEmail.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
    } else if (!(inputConfirmEmail.value === document.querySelector('input[name="email"]').value)) {
        error.textContent = "• Le email non coincidono";
    }    
}

function checkPassword(event) {
    const inputPassword = document.querySelector('input[name="password"]');

    const error = document.querySelector('#password_error');
    error.textContent = "";

    if(inputPassword.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
    } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(inputPassword.value)) {
        error.textContent = "• Formato password non corretta";
    }    
}

function checkConfirmPassword(event) {
    const inputConfirmPassword = document.querySelector('input[name="confirm_password"]');

    const error = document.querySelector('#confirm_password_error');
    error.textContent = "";

    if(inputConfirmPassword.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
    } else if (!(inputConfirmPassword.value === document.querySelector('input[name="password"]').value)) {
        error.textContent = "• Le password non coincidono";
    }    
}

function showPassword(event) {
    const check = document.querySelector('input[name="password"]');
    const confirmCheck = document.querySelector('input[name="confirm_password"]');
  
    if(check.type === "password") check.type = "text";
    else check.type = "password";

    if(confirmCheck.type === "password") confirmCheck.type = "text";
    else confirmCheck.type = "password";
}

const formStatus = {
    'username': true,
    'email': true,
};

document.querySelector('input[name="username"]').addEventListener('blur', checkUsername);
document.querySelector('input[name="email"]').addEventListener('blur', checkEmail);
document.querySelector('input[name="confirm_email"]').addEventListener('blur', checkConfirmEmail);
document.querySelector('input[name="password"]').addEventListener('blur', checkPassword);
document.querySelector('input[name="confirm_password"]').addEventListener('blur', checkConfirmPassword);
document.querySelector('input[name="show_password"]').addEventListener('click', showPassword);