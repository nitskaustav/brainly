
//Portfolio Toggle

/*$(function() {
    var selectedClass = "";
    $(".fil-cat").click(function() {
        selectedClass = $(this).attr("data-rel");
        $("#portfolio").fadeTo(100, 0.1);
        $("#portfolio div").not("." + selectedClass).fadeOut().removeClass('scale-anm');
        setTimeout(function() {
            $("." + selectedClass).fadeIn().addClass('scale-anm');
            $("#portfolio").fadeTo(300, 1);
        }, 300);
    });
});*/

//End Portfolio Toggle

//Owl carousel

/*var owl = $('.owl-carousel1');
owl.owlCarousel({
    items: 6,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    nav: true,
    dots: false,
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 4
        },
        1000: {
            items: 6
        }
    }
});

var owl = $('.owl-carousel2');
owl.owlCarousel({
    items: 6,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    nav: true,
    dots: false,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    }
});
*/

/*$('.play').on('click', function() {
    owl.trigger('play.owl.autoplay', [1000])
})
$('.stop').on('click', function() {
    owl.trigger('stop.owl.autoplay')
})*/

//End Owl carousel

$(window).scroll(function() {
    var sticky = $('.navbar-light'),
        scroll = $(window).scrollTop();

    if (scroll >= 100) sticky.addClass('black');
    else sticky.removeClass('black');
    
});
$('.navbar-toggler').on('click', function() {
	  var sticky = $('.navbar-light');
	  sticky.toggleClass('black-mobile');
});


//Go topr

/*$(window).scroll(function() {
    if ($(this).scrollTop()) {
        $('#toTop').fadeIn();
    } else {
        $('#toTop').fadeOut();
    }
});
$("#toTop").click(function() {
    $("html, body").animate({
        scrollTop: 0
    }, 1000);

});
*/
