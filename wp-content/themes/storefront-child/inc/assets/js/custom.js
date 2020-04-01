jQuery(function ($) {

    const wow = new WOW();
    wow.init();
    $(document).ready(function () {
        $('.card-payment.active').trigger('click')
    })

    $(document).on('click', '.btn.remove-book', function (event) {
        event.preventDefault();

        const $thisa = $(this)

        $.ajax({
            type: 'GET',
            url: $thisa.data('href'),
            dataType: 'html',
            beforeSend: function (response) {
                $thisa.addClass('loading');
                $thisa.prop('disabled', true);
            },
            success: function (response) {
                const $html = $.parseHTML(response);
                const $new_form = $('.card-payment-info', $html);
                const $new_totals = $('#basket-btn__counter', $html);
                if (document.documentElement.clientWidth < 576) {
                    const id = $thisa.parents('.card-payment').find('.card-payment-info__content').attr('id')
                    const $new_btn = $(`#${id} .single_add_to_cart_button_new`, $html);
                    $thisa.replaceWith($new_btn);
                } else {
                    $('.card-payment-info').replaceWith($new_form);
                }
                if ($new_totals.text() == 0){
                    $('#basket-btn__counter').remove()
                } else {
                    $('#basket-btn__counter').replaceWith($new_totals);
                }
            },
            complete: function () {
                $thisa.removeClass('loading');
                $thisa.prop('disabled', false);
                $.scroll_to_notices($('[role="alert"]'));

            }
        });
    });

    $('.carousel-books').each(function () {
        let id = $(this).attr('id')
        if (document.documentElement.clientWidth < 576) {
            var swiper = new Swiper(this, {
                slidesPerView: 3,
                spaceBetween: 30,
                effect: 'fade',
                loop: !!($(this).hasClass('loop') || document.documentElement.clientWidth < 576),
                breakpoints: {
                    576: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
                navigation: {
                    nextEl: $(`[data-href='${id}'] .carousel-books-control-next`),
                    prevEl: $(`[data-href='${id}'] .carousel-books-control-prev`),
                },
            });
        } else {
            var swiper = new Swiper(this, {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: !!($(this).hasClass('loop') || document.documentElement.clientWidth < 576),
                breakpoints: {
                    576: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
                navigation: {
                    nextEl: $(`[data-href='${id}'] .carousel-books-control-next`),
                    prevEl: $(`[data-href='${id}'] .carousel-books-control-prev`),
                },
            });
        }

    });

    if (document.documentElement.clientWidth < 576) {
        var swiperPopular = new Swiper('#popularCards', {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            effect: 'fade',
            breakpoints: {
                576: {
                    slidesPerView: 1,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                991: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
            navigation: {
                nextEl: $('.popular-next'),
                prevEl: $('.popular-prev'),
            },
        });
    } else {
        var swiperPopular = new Swiper('#popularCards', {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            breakpoints: {
                576: {
                    slidesPerView: 1,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                991: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
            navigation: {
                nextEl: $('.popular-next'),
                prevEl: $('.popular-prev'),
            },
        });
    }


    const $page = $('html, body');
    $('a.link[href*="#"]').on('click', function () {
        let blockId = $.attr(this, 'href');
        if ($('.checkbox-toggle').is(':checked')) {
            $('.checkbox-toggle').trigger('click')
        }
        console.log(blockId)
        $page.animate({
            scrollTop: $(`${blockId}`).offset().top - 30
        }, 1000);
        return false;
    });

    $('.checkbox-toggle').on('change', function () {
        if ($('.checkbox-toggle').is(':checked')) {
            $('body').addClass('overflow-hidden');
        } else {
            $('body').removeClass('overflow-hidden');
        }
    });

    if (document.documentElement.clientWidth < 768){
        $('.card-payment:not(".disabled")').on('click', function () {
            let input = $(this).find('input');
            let target = input.data('target');
            input.attr('checked', true);
            if (input.is(':checked') && !$(this).find(`#${target}`).is(':visible')) {
                $('.card-payment').removeClass('active');
                $.when($('.card-payment-info__content').slideUp(200)).done(() => {
                    let block = $(`#${target}`)
                    $(this).append(block)
                    block.slideDown(400);
                });
                $(this).addClass('active')
            }
        })
    }else {
        $('.card-payment:not(".disabled")').on('click', function () {
            let dataId = $(this).data('id')
            $('#pa_book_type').val(dataId).trigger('change')
            let input = $(this).find('input');
            let target = input.data('target');
            input.attr('checked', true);
            if (input.is(':checked')) {
                $('.card-payment').removeClass('active');
                $.when($('.card-payment-info__content').fadeOut(50)).done(() => {
                    $(`#${target}`).fadeIn(150);
                });
                $(this).addClass('active')
            }
        })
    }

    const bookBlock = $('.popular-block-card');
    const carouselHover = $('#carouselHover');

    if (document.documentElement.clientWidth >= 768) {
        bookBlock.mouseenter(function () {
            let blockId = $(this).data('active')
            $(`#${blockId}`).addClass('active')
            $('#carouselHover').addClass('active-nav')
            carouselHover.fadeIn(200)


            popularWowReInit()
        })

        carouselHover.mouseleave(function () {

            carouselHover.fadeOut(500);
            carouselHover.addClass('pointer-events-none');
            setTimeout(() => {
                $('.popular-hover-card').removeClass('active')
                $('#carouselHover').removeClass('active-nav')
                carouselHover.removeClass('pointer-events-none');
            }, 500);

            $("#carouselExampleIndicators").removeClass("wow");

        })

        $('#carouselHover .carousel-control-next').click(function () {
            popularWowReInit();
        })

        $(window).scroll(function () {
            let wows = $('.main-social').find(".wow");

            if (wows) {
                if ($(wows).hasClass('animated')) {
                    setTimeout(() => {

                        $(wows).removeClass('animated');
                        $(wows).removeClass('wow');
                        $(wows).removeAttr('style');

                    }, 1000);

                }
            }

        });
    }

    function popularWowReInit() {


        // Если анимация уже была показана, то обнуляем
        if ($('.wow').hasClass('animated')) {
            $(this).removeClass('animated');
            $(this).removeAttr('style');
            new WOW().init();

        }

        // Этот велосипед нужен для того, чтобы срабатывал Wow js, так как он активируется при скролле
        // Жду предложения сделать это нормально
        let y = $(window).scrollTop();
        $(window).scrollTop(y + 1000);
        $(window).scrollTop(y);

    }

    $('.triggerModal').on('click', function () {
        const $this = $(this);
        const $modal = $('#commentModal')
        $modal.modal('show')
        let title = $this.data('title')
        let text = $this.data('text')

        $modal.find('.comment-content-target').text(text)
        $modal.find('.comment-title-target').text(title)

    })


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    // Обработка карточки с пожертвованием

    $(".radio-button__radio_side_left").on("click", function (e) {
        $("#payByWallet").prop("checked", true);
        $(".radio-button__radio_side_left").addClass("radio-button__radio_checked_yes");
        $(".radio-button__radio_side_right").removeClass("radio-button__radio_checked_yes");
    });

    $(".radio-button__radio_side_right").on("click", function (e) {
        $("#payByCard").prop("checked", true);
        $(".radio-button__radio_side_right").addClass("radio-button__radio_checked_yes");
        $(".radio-button__radio_side_left").removeClass("radio-button__radio_checked_yes");
    });

    $(".input-donate").on("click", function () {
        this.value = "";
        $("#inputDonateText").text("");
    });

    $(".input-donate").focusout(function () {
        console.log(this.value)
        if (this.value === "") {
            this.value = 100;
            $("#inputDonateText").text(this.value)
        }
    });

    $(".input-donate").on("input", function () {
        if (this.value.length > 7) {
            this.value = this.value.slice(0, 7);
        }

        if (this.value > 15000) {
            this.value = 15000;
        }

        $("#inputDonateText").text(this.value)
    });


});

