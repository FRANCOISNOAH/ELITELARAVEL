// =========== Company Info Page Script ===============
// ====================================================

// ===> Gestion form slide
let DOMS = {
    slide1 : "#bloc-1",
    slide2 : "#bloc-2",
    allIndicators : ".register-indicators li",
    allSlide : ".accor-register .slide-item",
    slideIndicator1 : ".register-indicators li:nth-child(1)",
    slideIndicator2 : ".register-indicators li:nth-child(2)",
    nextBtn : "#nextBtn"
}

// Au clic sur le bouton suivant
document.querySelector(DOMS.nextBtn).addEventListener('click', function() {
    // 1. Validation du formulaire 

    // 2. Changement de slide
    document.querySelectorAll(DOMS.allSlide).forEach(function(current){
        current.classList.remove('active')
    });
    document.querySelectorAll(DOMS.allIndicators).forEach(function(current){
        current.classList.remove('active');
    });
    
    let targetId = this.getAttribute('data-target');
    document.querySelector(targetId).classList.add('active');
    document.querySelector("li[data-target='" + targetId + "']").classList.add('active');
});

document.querySelector(DOMS.slideIndicator1).addEventListener('click', function(){
    if(this.classList.contains('active')) return;

    // 2. Changement de slide
    document.querySelectorAll(DOMS.allSlide).forEach(function(current){
        current.classList.remove('active')
    });
    document.querySelectorAll(DOMS.allIndicators).forEach(function(current){
        current.classList.remove('active');
    });
    
    let targetId = this.getAttribute('data-target');
    document.querySelector(targetId).classList.add('active');
    document.querySelector("li[data-target='" + targetId + "']").classList.add('active');
});