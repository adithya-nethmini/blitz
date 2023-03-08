const menu = document.querySelector(".menu");
const ulTopNavLanding = document.querySelector(".ul-top-nav-landing");
const topNavLink = document.querySelectorAll(".top-nav-link");

menu.addEventListener("click", mobileMenu);
topNavLink.forEach(n => n.addEventListener("click", closeMenu));

function mobileMenu() {
    menu.classList.toggle("active");
    ulTopNavLanding.classList.toggle("active");
}

function closeMenu() {
    menu.classList.remove("active");
    ulTopNavLanding.classList.remove("active");
}