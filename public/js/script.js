let playOnce = true;


window.addEventListener("scroll", () => {
    // Navbar effect
    if (window.scrollY > 50) {
        navbar.style.height = "45px";
    } else {
        navbar.style.height = "90px";
    }
});


//image
let scrollvalue = 
    (window.scrollY + window.innerHeight) / document.body.offsetHeight;
if (scrollvalue > 0.40) {
    imgImprovise.style.opacity = 1;
    imgImprovise.style.transform = "none";
}

  //popup
if (scrollvalue > 0.85 && playOnce) {
    popup.style.opacity = 1;
    popup.style.transform = "none";
    playOnce = false;
}

  //evenement au clic (fermer la popup)
closeBtn.addEventListener("click", () => {
    popup.style.opacity = 0;
    popup.style.transform = "translateX(500px)";
});



