function showMaster() {
    document.getElementById("info-master").style.display = "block";
    document.getElementById("blackBackground").style.display = "block";
}

function showSite() {
    document.getElementById("info-site").style.display = "block";
    document.getElementById("blackBackground").style.display = "block";
}

function show2048() {
    document.getElementById("info-2048").style.display = "block";
    document.getElementById("blackBackground").style.display = "block";
}

function showRPG() {
    document.getElementById("info-rpg").style.display = "block";
    document.getElementById("blackBackground").style.display = "block";
}

function hideInfo() {
    document.getElementById("blackBackground").style.display = "none";
    document.getElementById("info-master").style.display = "none";
    document.getElementById("info-site").style.display = "none";
    document.getElementById("info-2048").style.display = "none";
    document.getElementById("info-rpg").style.display = "none";
    document.getElementById("mobile-nav-overlay").style.display = "none";
}

function showMobileMenu() {
    document.getElementById("mobile-nav-overlay").style.display = "flex";
    document.getElementById("blackBackground").style.display = "block";
}

function next(className) {
    var elements = document.getElementsByClassName(className);
    var done = false;

    for(i = 0; i < elements.length -1; i++) {
        if(elements[i].classList.contains("visible")) {
            elements[i].classList.remove("visible");
            elements[i].classList.add("invisible");
            elements[i+1].classList.remove("invisible");
            elements[i+1].classList.add("visible");
            done = true;
            break;
        }
    }
    if(!done) {
        elements[elements.length-1].classList.remove("visible");
        elements[elements.length-1].classList.add("invisible");
        elements[0].classList.remove("invisible");
        elements[0].classList.add("visible")
    }
}