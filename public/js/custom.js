$(document).ready(function() {
    $('.slider-wrapper .slider-item').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3000,
    });
    $('.popular-product .product-item').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        items: 4,
        dots: false,
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        // autoplay: true,
        // autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
                nav: false
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });

    $('.blog-post .blog-slider-item').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        items: 3,
        dots: false,
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
                nav: false
            },
            992: {
                items: 3,
            }
        }
    });
});