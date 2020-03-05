jQuery(function ($) {
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

    $('.card-payment').on('click', function () {
        let input = $(this).find('input');
        let target = input.data('target');
        input.attr('checked', true);
        if (input.is(':checked')) {
            $('.card-payment').removeClass('active');
            $.when($('.card-payment-info__content').fadeOut(100)).done(() => {
                $(`#${target}`).fadeIn(250);
            });
            $(this).addClass('active')
        }
    })
});
