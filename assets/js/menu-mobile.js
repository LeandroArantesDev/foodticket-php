const btn_menu = document.getElementById("btn-menu");
const btn_icon = document.querySelector(".btn-menu i")
const menu = document.querySelector(".menu");

btn_menu.addEventListener("click", () => {
    if (btn_icon.classList.contains("fa-bars")) {
        btn_icon.classList.replace("fa-bars", "fa-x");
    } else {
        btn_icon.classList.replace("fa-x", "fa-bars");
    }
    menu.classList.toggle("ativo");
})