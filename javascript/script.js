function showProject(id) {
    showBlackBackground();
    $("#all-projects").fadeIn();
    $(id).fadeIn();
}

function nextProject() {
    /**
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
    */
    $('#all-projects').children('div').each(function () {
        if ($(this).is(":visible")) {
            $(this).fadeOut();
            $(this).promise().done(function () {
                $(this).next().fadeIn();
            });
            return false;
        }
    });

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
    $("#all-projects").fadeOut();
    $("#mobile-nav-overlay").fadeOut();
}



function showBlackBackground() {
    $("#blackBackground").fadeIn();
}

function hideBlackBackground() {
    $("#blackBackground").fadeOut();
}

function showMobileMenu() {
    showBlackBackground();
    $("#mobile-nav-overlay").css('display', 'flex');
}

function hideMobileMenu() {
    hideBlackBackground();
    $("#mobile-nav-overlay").hide();
}

function nextPhoto(image) {
    var elements = image.parentNode.getElementsByTagName("img");

    for(i = 0; i < elements.length; i++) {
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
                elements[0].classList.add("visible")
            }
        }
    }
}

$(function() {

    $("a[href*='#']:not([href='#'])").click(function() {
        if (
            location.hostname == this.hostname
            && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
        ) {
            var anchor = $(this.hash);
            anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                $("html, body").animate( { scrollTop: anchor.offset().top }, 1000);
            }
        }
    });
});

