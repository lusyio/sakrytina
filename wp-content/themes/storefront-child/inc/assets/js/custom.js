jQuery(function ($) {
    new WOW().init();

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

    const bookBlock = $('.popular-block-card');
    const carouselHover = $('#carouselHover');

    bookBlock.mouseenter(function () {
        let blockId = $(this).data('active')
        $(`#${blockId}`).addClass('active')
        $('#carouselHover').addClass('active-nav')
        carouselHover.fadeIn(200)
    })

    carouselHover.mouseleave(function () {
        $('.popular-hover-card').removeClass('active')
        $('#carouselHover').removeClass('active-nav')
        carouselHover.fadeOut(350)
    })

    $('.triggerModal').on('click', function () {
        const $this = $(this);
        const $modal = $('#commentModal')
        $modal.modal('show')
        let title = $this.data('title')
        let text = $this.data('text')

        $modal.find('.comment-content-target').text(text)
        $modal.find('.comment-title-target').text(title)

    })


    $('.comment-content-target')

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(".radio-button__radio_side_left").on("click", function(e){
        $("#payByWallet").prop("checked", true);
        $(".radio-button__radio_side_left").addClass("radio-button__radio_checked_yes");
        $(".radio-button__radio_side_right").removeClass("radio-button__radio_checked_yes");
    });
    
    
    $(".radio-button__radio_side_right").on("click", function(e){
        $("#payByCard").prop("checked", true);
        $(".radio-button__radio_side_right").addClass("radio-button__radio_checked_yes");
        $(".radio-button__radio_side_left").removeClass("radio-button__radio_checked_yes");
    });
});