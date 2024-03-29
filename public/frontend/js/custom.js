$(document).ready(function() {
    "use strict";

    // Mobile Menu
    $('.js-click-megamenu').on('click', function(event) {
        $(".box-mobile-menu").addClass('open')
        $(".menu-overlay").fadeIn();
        event.preventDefault()
    });
    $('.menu-overlay').on('click', function(event) {
        $(".box-mobile-menu").removeClass('open')
        $(".menu-overlay").fadeOut();
        event.preventDefault()
    });
    $('.close-menu').on('click', function(event) {
        $(".box-mobile-menu").removeClass('open')
        $(".menu-overlay").fadeOut();
        event.preventDefault()
    });

    // Toggle submenu mobile / responsive
    $(document).on('click', '.menu-item .toggle-submenu', function(e) {
        var $this = $(this);
        var $thisParent = $this.closest('.menu-item-has-children');
        if ($thisParent.length) {
            $thisParent.toggleClass('show-submenu').find('> .submenu').stop().slideToggle();
        }
        e.preventDefault();
        return false;
    });



    // CHOOSE NUMBER ORDER
    var value = parseInt($('#order-qty .quanlity-num').attr('value'));
    $('.quanlity #plus').click(function() {
        let order = $('#order-qty .quanlity-num');
        let numberOrder = parseInt(order.attr('max'));
        let minus = $('.quanlity #minus');
        if (value >= numberOrder) {
            value = numberOrder;
            $(this).prop('disabled', true);
            $(this).addClass('disabled');
        } else {
            value++;
            minus.prop('disabled', false);
            minus.removeClass('disabled');
        }
        $('#order-qty .quanlity-num').attr('value', value);
    });

    $('.quanlity #minus').click(function() {
        let plus = $('.quanlity #plus');
        if (value > 1) {
            plus.attr('disabled');
            value--;
            $('#order-qty .quanlity-num').attr('value', value);
            plus.prop('disabled', false);
            plus.removeClass('disabled');
        } else {
            $(this).prop('disabled', true);
            $(this).addClass('disabled');
        }
    });


    //Change product detail
    $(document).mouseup(function(e) {
        let listCategory = $('.list-category');
        if (!listCategory.is(e.target) // if the target of the click isn't the container...
            &&
            listCategory.has(e.target).length === 0) // ... nor a descendant of the container
        {
            listCategory.removeClass('show');
        }

    });

    $('.category-show').click(function(e) {
        let parent = $(this).closest('.filter-right-show');
        $('.list-category', parent).toggleClass('show');
    });


    //Change price fillter
    $('.submit-fillter-price input').click(function(e) {
        e.preventDefault();
        let current = $(this);
        let parent = current.closest('#price-fillter');
        let priceFillter = $('#price-fillter #price-change');
        var min = priceFillter.data("from"); // input data-from attribute
        var max = priceFillter.data("to"); // input data-to attribute
        var token = $('meta[name="csrf-token"]').attr('content');
        let url = $('.action-fillter-price', parent).data('action');
        let request = $('.action-request-url', parent).data('request');
        let data = { min: min, max: max, _token: token, request: request };
        $('.loader-wrapper').show();
        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            dataType: 'text',
            success: function(data) {
                $('.result-fillter').html(data);
                $('.loader-wrapper').hide();
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status);
                alert(throwError);
            }
        });
    });

    let pageLoadmore = 1;
    //LoadMore data
    $('.load-more .load-more-item').click(function(e) {
        e.preventDefault();
        let parent = $(this).closest('.load-more');
        pageLoadmore++;
        let url = $('.action-load-more', parent).val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: url,
            method: 'POST',
            data: { page: pageLoadmore, _token: token },
            dataType: 'text',
            success: function(data) {
                if (data.length == 0) {
                    $('.load-more .load-more-item').prop('disabled', true);
                }
                $('.result-load-more').append(data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status);
                alert(throwError);
            }
        });
    });

    //LoadMore Date Product
    $('.load-more-category .load-more-item').on("click", function(e) {
        e.preventDefault();
        let parent = $(this).closest('.load-more-category');
        pageLoadmore++;
        let url = $('.action-load-more', parent).val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: url,
            method: 'POST',
            data: { page: pageLoadmore, _token: token },
            dataType: 'text',
            success: function(data) {
                console.log(data.length);
                if (data.length == 0) {
                    $('.load-more-category .load-more-item').prop('disabled', true);
                }
                $('.result-load-more').append(data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status);
                alert(throwError);
            }
        });
    });

    var qty_product = $('.product-color .color-item').find('.color-info').data('qty');
    // if (qty_product <= 0) {
    //     $('.product-info-detail .product-out-stock').show();
    //     $('.product-info-detail .product-size').hide();
    //     $('.product-color .color-item').attr('title', 'Sản phẩm tạm hết hàng');
    //     $('[data-toogle="tooltip"]').tooltip();
    //     $('.product-color .color-item').find('.color-info').attr('disabled', true);
    //     $('.product-color .color-item').find('.color-info').addClass('disabled');
    //     $('.product-info-detail').find('.product-detail-buy').append("<div class='overlay-product'></div>");
    // } else {
    //     $('.product-color .color-item').each(function(item) {
    //         $('.product-color .color-item').first().addClass('active');
    //         $('.product-color .color-item').first().find('.color-info').attr('checked', true);
    //         let dataSize = $('.product-color .color-item').first().find('.color-info').data('size');
    //         let qty = $('.product-color .color-item').first().find('.color-info').data('qty');
    //         if (parseInt(qty) <= 0) {
    //             $(this).closest('.product-info-detail').find('.product-detail-buy').append("<div class='overlay-product'></div>");
    //         }
    //         $('.size-info option').each(function() {
    //             let result = $(this).val();
    //             if (parseInt(dataSize) == parseInt(result)) {
    //                 $('.size-info option').removeClass('op-disabled');
    //                 $('.size-info option').removeAttr('selected');
    //                 $('.size-info option').removeAttr('disabled');
    //                 $(this).attr('selected', 'selected');
    //                 $(".size-info option").not(this).addClass('op-disabled');
    //                 $(".size-info option").not(this).attr("disabled", true);
    //             }
    //         });
    //         $('.product-color .color-item').on("change", function() {
    //             let current = $(this);
    //             $('.product-color .color-item').removeAttr('checked');
    //             $('.product-color .color-item').removeClass('active');
    //             current.addClass('active');
    //             let size = current.find('.color-info').data('size');
    //             let qty = current.find('.color-info').data('qty');
    //             let productQty = current.closest('.product-info-detail').find('.quanlity .quanlity-num');
    //             productQty.attr('max', qty);
    //             console.log(size);
    //             if (qty <= 0) {
    //                 $(this).closest('.product-info-detail').find('.product-detail-buy').append("<div class='overlay-product'></div>");
    //             }
    //             $('.size-info option').each(function() {
    //                 let result = $(this).val();
    //                 if (parseInt(qty) <= 0) {
    //                     $(this).attr("disabled", true);
    //                 } else {
    //                     if (parseInt(size) == parseInt(result)) {
    //                         $('.size-info option').removeClass('op-disabled');
    //                         $('.size-info option').removeAttr('selected');
    //                         $('.size-info option').removeAttr('disabled');
    //                         $(this).attr('selected', 'selected');
    //                         $(".size-info option").not(this).addClass('op-disabled');
    //                         $(".size-info option").not(this).attr("disabled", true);
    //                     }
    //                 }
    //             });
    //         });
    //     })
    // }
    // $('.product-size').find('.custom-select .size-active').hide();
    if (qty_product <= 0) {
        $('.product-info-detail .product-out-stock').show();
        $('.product-info-detail .product-size').hide();
        $('.product-color .color-item').attr('title', 'Sản phẩm tạm hết hàng');
        $('[data-toogle="tooltip"]').tooltip();
        $('.product-color .color-item').find('.color-info').attr('disabled', true);
        $('.product-color .color-item').find('.color-info').addClass('disabled');
        $('.product-size').find('.size-info').attr('disabled', true);
        $('.product-size').find('.size-info').addClass('disabled');
        $('.product-info-detail').find('.product-detail-buy').append("<div class='overlay-product'></div>");
    } else {
        $('.product-color .color-item').each(function(item) {
            $('.product-color .color-item').first().addClass('active');
            $('.product-color .color-item').first().find('.color-info').attr('checked', true);

            $('.product-color .color-item').change(function(e) {
                let current = $(this);
                $('.product-color .color-item').removeAttr('checked');
                $('.product-color .color-item').removeClass('active');
                current.addClass('active');
                let colorItem = current.find('.color-info').val();
                let slug = current.find('.slug-product').val();
                let url = current.find('.action-change-size').val();
                let token = $('meta[name="csrf-token"]').attr('content');
                let data = { colorItem: colorItem, _token: token, slug: slug };
                $('.product-size').find('.size-info .size-active').show();
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'text',
                    data: data,
                    success: function(data) {
                        $('.product-size .custom-select').html(data);
                    },
                    error: function(xhr, ajaxOption, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    }
                });
            });
        });

    }






    // $('.product-size .size-info').change(function() {
    //     let current = $(this);
    //     var option = $('option:selected', current).attr('data-color');
    //     $('.product-color .color-item').each(function() {
    //         let result = $(this).find('.color-info').val();
    //         if (parseInt(option) == parseInt(result)) {
    //             $('.product-color .color-item').removeClass('active');
    //             $(this).addClass('active');
    //         }
    //     });
    // });

    //Change shipping 
    $('input[type=radio][name=shipping]').change(function() {
        let total = $('.text-price .total-order').data('total');
        let shipping = 0;
        if (this.value == 'delivery') {
            shipping = 30.000;
            $('.text-price #total-ship').text(shipping.toFixed(3) + 'đ');
        } else if (this.value == 'free') {
            $('.text-price #total-ship').text(shipping + 'đ');
        }
        let elementShipping = $('.text-price #total-ship').text();

        let subTotal = parseFloat(total.replace(/\./g, '')) + parseFloat(elementShipping.replace(/\./g, ''));
        let numberFomart = new Intl.NumberFormat('vi', { style: 'currency', currency: 'VND' }).format(subTotal);
        $('.text-price .total-order').html(numberFomart);


    });

    //AJAX UPDATE CART
    $('.minus-change').click(function(e) {
        e.preventDefault();
        var element = $(this).closest('.cart-row');
        var qty = parseInt($('.number-order-quantity', element).attr('value'));
        var plusChange = $('.plus-change', element);
        let dataPrice = $('.data-price', element).val();
        if (qty > 1) {
            qty--;
            plusChange.removeClass('disabled');
        } else {
            $(this).addClass('disabled');
        }
        var action = $('.action-update-cart', element),
            url = action.data('action'),
            row = action.data('row'),
            id = action.data('id'),
            token = $('meta[name="csrf-token"]').attr('content'),
            data = { id: id, row: row, qty: qty, _token: token, dataPrice: dataPrice };
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                $('.price-total', element).text(data.total);
                $('.cart-total .total-item').text(data.sub_total);
                $('.number-order-quantity', element).attr('value', qty);
                $('.data-qty', element).attr('value', qty);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status);
                alert(throwError);
            }
        });
    });

    $('.plus-change').click(function(e) {
        e.preventDefault();
        var element = $(this).closest('.cart-row');
        var qty = parseInt($('.number-order-quantity', element).attr('value'));
        var action = $('.action-update-cart', element);
        var url = action.data('action');
        var id = action.data('id');
        var max = parseInt($('.number-order-quantity', element).attr('max'));
        var token = $('meta[name="csrf-token"]').attr('content');
        var minusChange = $('.minus-change', parent);
        let dataPrice = $('.data-price', element).val();
        if (qty < max) {
            qty++;
            minusChange.removeClass('disabled');
        } else if (qty == max) {
            $(this).addClass('disabled');
        }
        var data = { id: id, qty: qty, _token: token, dataPrice: dataPrice };
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                $('.price-total', element).text(data.total);
                $('.cart-total .total-item').text(data.sub_total);
                $('.number-order-quantity', element).attr('value', qty);
                $('.data-qty', element).attr('value', qty);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status);
                alert(throwError);
            }
        });
    });

    // Change product image slider

    $('.slider-nav .change-image img').click(function(e) {
        e.preventDefault();
        let current = $(this);
        let imgUrl = current.data('image');
        let item = $('.change-pr-img img');
        let changeImage = item.attr('src', imgUrl);
        console.log(imgUrl);
        console.log(changeImage);
    });




    //------- Client say page_01 --------//  
    $('.active-review-carusel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        margin: 30,
        dots: true
    });

    $('.active-clientsaylist').owlCarousel({
        items: 2,
        loop: true,
        autoplayHoverPause: true,
        dots: false,
        autoplay: false,
        nav: true,
        navText: ["<span class='lnr lnr-arrow-up'></span>", "<span class='lnr lnr-arrow-down'></span>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 1,
            }
        }
    });

    $('.active-brand-carusel').owlCarousel({
        items: 5,
        loop: true,
        autoplayHoverPause: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            455: {
                items: 2
            },
            768: {
                items: 3,
            },
            991: {
                items: 4,
            },
            1024: {
                items: 5,
            }
        }
    });


    //Scroll Menu page_02
    // document.addEventListener("DOMContentLoaded",function() {
    //     var menu = document.querySelectorAll('section.header-bottom');
    //     var menu = menu[0];
    //         //Truy xuất div menu
    //         var status="duoi150";
    //     window.addEventListener("scroll",function(){
    //         var x = pageYOffset;
    //         if(x > 150){
    //             if(status == "duoi150")
    //             {
    //                 status="tren150";
    //                 menu.classList.add('menutora');
    //             }
    //         }
    //         else{
    //             if(status=="tren150"){
    //             menu.classList.remove('menutora');
    //             status="duoi150";}
    //         }

    //     })
    // })

    // Search box homepage 1
    $('.js-search-box').on('click', function(event) {
        $(".search-box").addClass('search-box-active')
        $(".st1-search-box-bg").addClass('search-box-bg-active')
        event.preventDefault()
    });
    $('.close-search-box').on('click', function(event) {
        $(".search-box").removeClass('search-box-active')
        $(".st1-search-box-bg").removeClass('search-box-bg-active')
        event.preventDefault()
    });
    $('.st1-search-box-bg').on('click', function(event) {
        $(".search-box").removeClass('search-box-active')
        $(".st1-search-box-bg").removeClass('search-box-bg-active')
        event.preventDefault()
    });

    // Minicart
    $('.js-click-cart').on('click', function(event) {
        $(".hamadryad-minicart").addClass('open')
        $(".minicart-bg-overlay").fadeIn('slow');
        event.preventDefault()
    });
    $('.hamadryad-minicart-close').on('click', function(event) {
        $(".hamadryad-minicart").removeClass('open')
        $(".minicart-bg-overlay").fadeOut('slow');
        event.preventDefault()
    });
    $('.minicart-bg-overlay').on('click', function(event) {
        $(".hamadryad-minicart").removeClass('open')
        $(".minicart-bg-overlay").fadeOut('slow');
        event.preventDefault()
    });

    // Toggle submenu categories
    $(document).on('click', '.st3-categories-item .st3-categories-icon', function(e) {
        var $this = $(this);
        var $thisParent = $this.closest('.st3-categories-item-child');
        if ($thisParent.length) {
            $thisParent.toggleClass('show-subcate').find('> .sub-categories').stop().slideToggle();
        }
        e.preventDefault();
        return false;
    });



    // Slide Page 1


    $('.js-slide-previous').on('click', function(e) {
        $('.slick-prev').click();
        e.preventDefault();
    });

    $('.js-slide-next').on('click', function(e) {
        $('.slick-next').click();
        e.preventDefault();
    });

    // Sider Page3
    $('.categories-slide-right').slick({
        dots: false,
        arrows: false,
        autoplay: false,
        autoplaySpeed: 1500
    });


    // Sider About us
    $('.slide-aboutus').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500
    });

    // Slide Page 2
    $('.slide-page2').slick({
        dots: false,
        arrows: false,
        autoplay: false,
        autoplaySpeed: 1500
    });

    // Sider About us
    $('.slide-contactus').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500
    });

    //------- Deal of the week --------//  
    $('.active-review-carusel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        margin: 30,
        dots: true
    });

    $('.active-pro-dealof-theweek').owlCarousel({
        items: 4,
        loop: true,
        margin: 30,
        autoplayHoverPause: false,
        dots: false,
        autoplay: false,
        nav: true,
        navText: ["<span>Back</span>", "<span>Next</span>"],
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1024: {
                items: 3,
            },
            1280: {
                items: 4,
            },
            1440: {
                items: 4,
            }
        }
    });

    $('.active-brand-carusel').owlCarousel({
        items: 4,
        loop: true,
        autoplayHoverPause: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            455: {
                items: 2
            },
            768: {
                items: 3,
            },
            991: {
                items: 4,
            },
            1024: {
                items: 4,
            },
            1920: {
                items: 4,
            }
        }
    });

    //------- Popular Product , Related Products--------//  
    $('.active-review-carusel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        margin: 30,
        dots: true
    });
    $('.active-pro-relerate').owlCarousel({
        items: 3,
        loop: true,
        margin: 30,
        autoplayHoverPause: true,
        dots: false,
        autoplay: false,
        nav: false,
        navText: ["<span class='lnr lnr-arrow-up'></span>", "<span class='lnr lnr-arrow-down'></span>"],
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1024: {
                items: 3,
            },
            1280: {
                items: 4,
            },
            1440: {
                items: 4,
            }
        }
    });
    $('.active-brand-carusel').owlCarousel({
        items: 4,
        loop: true,
        autoplayHoverPause: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            455: {
                items: 2
            },
            768: {
                items: 3,
            },
            991: {
                items: 4,
            },
            1024: {
                items: 4,
            },
            1920: {
                items: 4,
            }
        }
    });

    // FOOTER HOMEPAGE 3
    $(document).on('click', '.icon-plus', function(e) {
        var $this = $(this);
        var $thisParent = $this.closest('.t-center-laptop');
        if ($thisParent.length) {
            $thisParent.toggleClass('show-submenu').find('> .f-content-list-item').stop().slideToggle();
        }
        e.preventDefault();
        return false;
    });

    // PRODUCT DETAIL V3
    $('.slider-single').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        vertical: true,
        arrows: false,
        verticalSwiping: true,
        asNavFor: '.slider-single',
        dots: false,
        focusOnSelect: true
    });

    // PRODUCT DETAIL V4
    $('.slider-single-v4').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav-v4'
    });
    $('.slider-nav-v4').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: false,
        verticalSwiping: true,
        asNavFor: '.slider-single-v4',
        dots: false,
        focusOnSelect: true
    });

    // POPUP QuickView
    $('.review').on('click', function(event) {
        $(".product-quick-view").addClass('quick-view-active')
        $(".product-quick-view-overlay").fadeIn();

        // Quick View galary image product
        $('.slide-quickview-single').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slide-quickview-nav'
        });
        $('.slide-quickview-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            vertical: true,
            arrows: false,
            verticalSwiping: true,
            asNavFor: '.slide-quickview-single',
            dots: false,
            focusOnSelect: true
        });
        event.preventDefault()
    });
    $('.product-quick-view-overlay').on('click', function(event) {
        $(".product-quick-view").removeClass('quick-view-active')
        $(".product-quick-view-overlay").fadeOut()
        event.preventDefault()
    });
    $('.close-quick-view').on('click', function(event) {
        $(".product-quick-view").removeClass('quick-view-active')
        $(".product-quick-view-overlay").fadeOut()
        event.preventDefault()
    });

    // POPUP Auto
    $('.wishlist').on('click', function(event) {
        $(".popup").addClass('popup-active')
        $(".popup-overlay").fadeIn();
        event.preventDefault()
    });
    $('.popup-overlay').on('click', function(event) {
        $(".popup").removeClass('popup-active')
        $(".popup-overlay").fadeOut()
        event.preventDefault()
    });
    $('.close-popup').on('click', function(event) {
        $(".popup").removeClass('popup-active')
        $(".popup-overlay").fadeOut()
        event.preventDefault()
    });


    // List - Gird Shop Page Fullwidth
    $('.list-js').on('click', function(event) {
        $('.box-item-list-shoppage').addClass('item-list-shoppage');
        $('.layout').removeClass("col-xl-3 col-md-6 col-lg-4 col-sm-6 col-12 transition-06").delay(10).queue(function(next) {
            $(this).addClass("col-xl-6 col-lg-6 col-md-6 col-custom-12 col-sm-12 col-12 list-pb");
            next();
        });
    });
    $('.grid-js').on('click', function(event) {
        $(".box-item-list-shoppage").removeClass('item-list-shoppage');
        $('.layout').removeClass("col-xl-6 col-lg-6 col-md-6 col-custom-12 col-sm-12 col-12 list-pb");
        $('.layout').addClass("col-xl-3 col-md-6 col-lg-4 col-sm-6 col-12 transition-06");
    });

    // List - Gird Shop Page Fullwidth Sidebar Left
    $('.sidebarleft-list-js').on('click', function(event) {
        $('.box-item-list-shoppage').addClass('item-list-shoppage');
        $('.sidebar-left-layout').removeClass("col-xl-4 col-md-6 col-lg-4 col-sm-12 col-12 transition-05").delay(10).queue(function(next) {
            $(this).addClass("col-xl-12 col-lg-12 col-md-12 list-pb");
            next();
        });
    });
    $('.sidebarleft-grid-js').on('click', function(event) {
        $(".box-item-list-shoppage").removeClass('item-list-shoppage');
        $('.sidebar-left-layout').removeClass("col-xl-12 col-lg-12 col-md-12 list-pb").delay(10).queue(function(next) {
            $(this).addClass("col-xl-4 col-md-6 col-lg-4 col-sm-12 col-12 transition-05");
            next();
        });
    });

    // SET WIDTH SUBMENU PAGE 1
    function setWidthFollowScreenPage1(selectorv1, comparev1, sub1v1, dadv1, sub2v1) {
        if ($(window).width() >= 1025) {
            var width = $(comparev1).width() - sub1v1;
            $(selectorv1).css({ 'width': function() { return width + 'px' } })
        }

        $(window).resize(function() {
            if ($(window).width() >= 1025) {
                var width = $(comparev1).width() - sub1v1;
                $(selectorv1).css({ 'width': function() { return width + 'px' } })
            }
        })
    }
    setWidthFollowScreenPage1('.js-dropmenuv1', '.js-comparev1', '160', '.js-dadv1', '80');

    // SET WIDTH SUBMENU
    function setWidthFollowScreen(selector, compare, sub1, dad, sub2) {
        if ($(window).width() >= 1025) {
            var width = $(compare).width() - sub1;
            $(selector).css({
                'width': function() { return width + 'px' },
                'left': function() {
                    var left_val = (($(window).width() - width) / 2) - $(dad).position().left;
                    console.log($(dad).position().left)
                    console.log($(window).width())
                    console.log(($(window).width() - width) / 2)
                    return left_val - sub2 + 'px';
                }
            })
        }

        $(window).resize(function() {
            if ($(window).width() >= 1025) {
                var width = $(compare).width() - sub1;
                $(selector).css({
                    'width': function() { return width + 'px' },
                    'left': function() {
                        var left_val = -($(dad).position().left - (($(window).width() - width) / 2));
                        return left_val - sub2 + 'px';
                    }
                })
            }
        })
    }
    setWidthFollowScreen('.js-dropmenu', '.js-compare', '260', '.js-dad', '80');

    // Popup auto show
    setTimeout(function() {
        $('.popup').addClass('popup-active');
    }, 2000);

    //  Range Slider Filter Product Price
    $(".js-range-slider").ionRangeSlider({

        type: "double",
        // min: 0,
        // max: 1000,
        // from: 200,
        // to: 500,
        step: 500,
        prettify_separator: '.',
        grid: false,
        postfix: "đ",
    });

    //  Range Slider Filter Product Price
    $(".js-range-slider1").ionRangeSlider({
        type: "double",
        min: 0,
        max: 1000,
        from: 200,
        to: 500,
        grid: false
    });

    // SET HEIGHT BOX BG PAGE-1
    function setheightSlide(selector1, compare1) {
        if ($(window).width() >= 1025) {
            var height = $(compare1).height();
            height = height + 35;
            $(selector1).css({
                'height': function() {
                    console.log(height)
                    return height + 'px'
                }
            })
        }
        if ($(window).width() >= 1280) {
            var height = $(compare1).height();
            height = height + 75;
            $(selector1).css({
                'height': function() {
                    console.log(height)
                    return height + 'px'
                }
            })
        }
    }
    setheightSlide('.js-box-bg', '.js-box-space');

    // BTN SIDEBAR MOBIE
    function showSidebar() {
        $('.js-filter').on('click', function() {
            $('.js-fix-sidebar').toggleClass('sidebar-active');
            if ($('.js-fix-sidebar').hasClass('sidebar-active')) {
                $('.js-filter span').removeClass('fa-filter').addClass('fa-times');
            } else {
                $('.js-filter span').removeClass('fa-times').addClass('fa-filter');
            }
        })
    }
    showSidebar();

    // Add active class to the multi layout
    // var header = document.getElementById("multiLayout");
    // var btns = header.getElementsByClassName("view-icon");
    // for (var i = 0; i < btns.length; i++) {
    //     btns[i].addEventListener("click", function() {
    //         var current = document.getElementsByClassName("actived");
    //         console.log(current);
    //         if (current.length > 0) {
    //             current[0].className = current[0].className.replace(" actived", "");
    //         }
    //         this.className += " actived";
    //     });
    // }

});