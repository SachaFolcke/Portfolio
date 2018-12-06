function showProject(id) {
    showBlackBackground();
    document.getElementById(id).style.display = "block";
}


function hideProject() {
    hideBlackBackground();
    var projects = document.getElementById("all-projects").getElementsByTagName("div");
    for(var i = 0; i < projects.length; i++){
        projects[i].style.display = "none";
    }
    document.getElementById("mobile-nav-overlay").style.display = "none";
}



function showBlackBackground() {
    document.getElementById("blackBackground").style.display = "block";
}

function hideBlackBackground() {
    document.getElementById("blackBackground").style.display = "none";
}

function showMobileMenu() {
    showBlackBackground();
    document.getElementById("mobile-nav-overlay").style.display = "flex";
}

function nextPhoto(className) {
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