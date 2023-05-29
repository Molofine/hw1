function apriMenu(event) {
    console.log("cliccato");
    sidebar = document.querySelector("#sidebar");

    if(sidebar.classList.contains('hidden')) {
        sidebar.classList.remove("hidden");
        document.body.classList.add('no-scroll');
    } else {
        sidebar.classList.add("hidden");
        document.body.classList.remove('no-scroll');
    }
}

document.querySelector("#sidebar-icon").addEventListener("click", apriMenu);