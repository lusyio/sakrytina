jQuery(function ($) {


    $(document).on('click', '.single_add_to_cart_button_new', function (e) {

        e.preventDefault();

        let $thisbutton = $(this),

            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;

        const data = {

            action: 'ql_woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,

        };

        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
                $thisbutton.removeClass('added').addClass('loading');
                $thisbutton.prop('disabled', true)
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
                $thisbutton.prop('disabled', false)
            },
            success: function (response) {
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    // $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    $thisbutton.replaceWith(response.fragments.paymentInfo);
                    $('.btn.remove-book').data('product_id', product_id)
                    if (!$('#basket-btn__counter').is(':visible')) {
                        $('.basket-btn').append(response.fragments.basket);
                    } else {
                        $('#basket-btn__counter').replaceWith(response.fragments.basket);
                    }

                }
            },
        });
    });
});