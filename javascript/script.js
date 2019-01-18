function showProject(id) {
    showBlackBackground();
    $("#all-projects").fadeIn();
    $(id).fadeIn();
}

function nextProject() {

    projects = $('#all-projects').find('.projet');
    projects.each(function () {
        if ($(this).is(':visible')) {
            $(this).fadeOut();
            $(this).promise().done(function () {
                if(($(this).next().attr('id') != "navProjectBar")) {
                    $(this).next().fadeIn();
                } else {
                    projects.first().fadeIn();

                }
            });
            return false;
        }
    });

}

function previousProject() {

    projects = $('#all-projects').find('.projet');
    projects.each(function () {
        if ($(this).is(':visible')) {
            $(this).fadeOut();
            $(this).promise().done(function () {
                if (($(this).prev().attr('id') != undefined)) {
                    $(this).prev().fadeIn();
                } else {
                    projects.last().fadeIn();


                }
            });
            return false;
        }
    });
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
    $("#mobile-nav-overlay").css('display', 'flex').hide().fadeIn();
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


/**
function isScrolledIntoView($elem, $window) {
    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
$(document).on("scroll", function () {
    var $window = $(window);
    var elem = $('#presentation');
    if (isScrolledIntoView($elem, $window)) {
        alert("yooo");
        $elem.addClass("animate")
    }
});
 */

