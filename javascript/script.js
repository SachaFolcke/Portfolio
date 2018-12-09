function showProject(id) {
    showBlackBackground();
    document.getElementById('all-projects').style.display = "block";
    document.getElementById(id).classList.remove("invisible");
    document.getElementById(id).classList.add("visible");
}

function nextProject() {
    var elements = document.getElementsByClassName("projet");
    for(i = 0; i < elements.length; i++){
        if(elements[i].classList.contains("visible")) {
            if(i != elements.length-1) {
                elements[i].classList.remove("visible");
                elements[i].classList.add("invisible");
                elements[i + 1].classList.remove("invisible");
                elements[i + 1].classList.add("visible");
                break;
            } else {
                elements[elements.length-1].classList.remove("visible");
                elements[elements.length-1].classList.add("invisible");
                elements[0].classList.remove("invisible");
                elements[0].classList.add("visible");
                break;
            }
        }
    }
}

function previousProject() {
    var elements = document.getElementsByClassName("projet");
    for(i = 0; i < elements.length; i++){
        if(elements[i].classList.contains("visible")) {
            if(i != 0) {
                elements[i].classList.remove("visible");
                elements[i].classList.add("invisible");
                elements[i - 1].classList.remove("invisible");
                elements[i - 1].classList.add("visible");
                break;
            } else {
                elements[0].classList.remove("visible");
                elements[0].classList.add("invisible");
                elements[elements.length-1].classList.remove("invisible");
                elements[elements.length-1].classList.add("visible");
                break;
            }
        }
    }
}

function hideProject() {
    hideBlackBackground();
    var projects = document.getElementsByClassName("projet");
    for(var i = 0; i < projects.length; i++){
        if(projects[i].classList.contains("visible")) {
            projects[i].classList.remove("visible");
        }
        if(!projects[i].classList.contains("invisible")) {
            projects[i].classList.add("invisible");
        }
    }
    document.getElementById("all-projects").style.display = "none";
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