jQuery(function ($) {
    const $page = $('html, body');
    $('a[href*="#"]').on('click', function () {
        let blockId = $.attr(this, 'href').slice(1)
        if ($('.checkbox-toggle').is(':checked')) {
            $('.checkbox-toggle').trigger('click')
        }
        $page.animate({
            scrollTop: $(`${blockId}`).offset().top - 50
        }, 1500);
        return false;
    });

    $('.checkbox-toggle').on('change', function () {
        if ($('.checkbox-toggle').is(':checked')) {
            $('body').addClass('overflow-hidden');
        } else {
            $('body').removeClass('overflow-hidden');
        }
    });
});
