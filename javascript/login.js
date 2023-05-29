function checkUsername(event) {

    const input = document.querySelector('input[name="username"]');

    if(input.value == "") {
        const error = document.querySelector('#username_error');
        error.textContent = "• Non può essere lasciato vuoto";
    }    
}

function checkPassword(event) {

    const input = document.querySelector('input[name="password"]');

    if(input.value == "") {
        const error = document.querySelector('#password_error');
        error.textContent = "• Non può essere lasciato vuoto";
    }    
}

function showPassword(event) {
    const check = document.querySelector('input[name="password"]');
  
    if(check.type === "password") check.type = "text";
    else check.type = "password";
}

document.querySelector('input[name="username"]').addEventListener('blur', checkUsername);
document.querySelector('input[name="password"]').addEventListener('blur', checkPassword);
document.querySelector('input[name="show_password"]').addEventListener('click', showPassword);