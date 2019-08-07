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
    $("#all-projects").find('.projet').filter(':visible').fadeOut();
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
    $("#mobile-nav-overlay").fadeOut();
}

function nextPhoto() {

    var projet = $("#all-projects").find('.projet').filter(':visible');
    var images = projet.find('img');
    images.each(function () {
        if ($(this).is(':visible')) {
            $(this).fadeOut(150);
            $(this).promise().done(function () {
                if (($(this).next().attr('src') != undefined)) {
                    $(this).next().fadeIn(150);
                } else {
                    images.first().fadeIn(150);
                }
            });
            return false;
        }
    })
}

function prevPhoto(){
    var projet = $("#all-projects").find('.projet').filter(':visible');
    var images = projet.find('img');
    images.each(function () {
        if ($(this).is(':visible')) {
            $(this).fadeOut(150);
            $(this).promise().done(function () {
                if (($(this).prev().attr('src') != undefined)) {
                    $(this).prev().fadeIn(150);
                } else {
                    images.last().fadeIn(150);
                }
            });
            return false;
        }
    })
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

$(document).ready ( function(){
    if($(window).width() <= 639) {
        $('#flexcontain').find('div').attr('data-aos-delay', '0');
        $('#contain').find('div').attr('data-aos-delay', '0');
    }
});

jQuery('img.svg').each(function(){
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');

});

