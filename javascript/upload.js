function checkDesc(event) {
    const inputDesc = document.querySelector('input[name="description"]');

    const error = document.querySelector('#desc_error');
    error.textContent = "";

    if(inputDesc.value == "") {
        error.textContent = "• Non può essere lasciato vuoto";
    }       
}

function checkFile(event) {
    const inputFoto = document.querySelector('input[name="foto"]');
    const preview = document.querySelector('#preview');
    preview.parentNode.classList.add("hidden");
    const size = inputFoto.files[0].size;
    const ext = inputFoto.files[0].name.split('.').pop();
    preview.src = URL.createObjectURL(inputFoto.files[0]);

    const error = document.querySelector('#file_error');
    error.textContent = "";

    if(size === 0) {
        error.textContent = "• Non può essere lasciato vuoto";
    } else if(!['jpeg', 'jpg', 'png'].includes(ext))  {
        error.textContent = "• Tipo di file non valido";
    } else preview.parentNode.classList.remove("hidden");

    
}

function onResponse(response){
    console.log(response);
    return response.json();
}

document.querySelector('input[name="foto"]').addEventListener('blur', checkFile);
document.querySelector('input[name="description"]').addEventListener('blur', checkDesc);