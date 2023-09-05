
$(document).ready(function() {

    $("body").css("padding-top", $(".header").height());

    $('#banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/images/left-arrow.png'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/images/right-arrow.png'>"
    });
    $('.featured-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/images/left-arrow.png'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/images/right-arrow.png'>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.faq-question').click(function() {
        $('.faq-answer').css('height', '0px');
        $(this).siblings().css('height', 'auto');
    });


    $('.testimonials-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        centerMode: true,
        arrows: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/images/left-arrow.png'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/images/right-arrow.png'>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });


    $('.product-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/images/left-arrow.png'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/images/right-arrow.png'>"
    });

    $('.prod-options-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 5
    });

    $(".menu-btn").click(function() {
        $(".menu-wrapper").toggle();
        $(".header-backdrop").toggle();
    });

    $(".header-backdrop").click(function() {
        $(".menu-wrapper").toggle();
        $(".header-backdrop").toggle();
    });
});