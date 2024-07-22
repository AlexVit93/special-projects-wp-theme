jQuery(document).ready(function($) {
    $('.testimonials__slider').slick({
        prevArrow: '.testimonials__arrow--prev',
        nextArrow: '.testimonials__arrow--next',
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
        {
            breakpoint: 1200,
            settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            },
        },
        {
            breakpoint: 1024,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            },
        },
        {
            breakpoint: 600,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            },
        },
        {
            breakpoint: 480,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            },
        },
        {
            breakpoint: 320,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            },
        },
        ],
    });
});
