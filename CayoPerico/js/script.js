document.getElementById("icon_menu").addEventListener("click", mostrar_menu);

function mostrar_menu(){

    document.querySelector(".menu").classList.toggle("mostrar_menu");
    
}

window.onscroll = function () {
    var posicion = window.pageYOffset || document.documentElement.scrollTop;
    var elemento1 = document.getElementById("icon_heart");
    var elemento2 = document.getElementById("icon_fire");
    elemento1.style.bottom = posicion * 0.1 + "px";
    elemento2.style.top = posicion * 0.1 + "px";
}

// Animación para el header
gsap.from(".container__header", {
    duration: 1.5,
    opacity: 0,
    y: -50,
    ease: "power4.out"
});

// Animación para la sección de la portada
gsap.from(".cover", {
    duration: 1.5,
    opacity: 0,
    y: 100,
    ease: "power4.out",
    delay: 0.5
});

// Animación para el banner
gsap.from(".banner", {
    duration: 1.5,
    opacity: 0,
    scale: 0.8,
    ease: "elastic.out(1, 0.5)",
    delay: 1
});

// Animación para cada ícono del banner
gsap.from("#icon_heart, #icon_fire", {
    duration: 1,
    opacity: 0,
    y: 30,
    ease: "back.out(1.7)",
    delay: 1.2,
    stagger: 0.2
});



