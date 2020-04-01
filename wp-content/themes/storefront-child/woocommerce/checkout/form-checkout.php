<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>
<div class="row">

    <div class="col-12 pl-lg-3 pr-lg-3 p-0">
        <div class="new-checkout">
            <div class="new-checkout__body">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <form name="checkout" method="post" class="checkout woocommerce-checkout"
                              action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                            <?php if ($checkout->get_checkout_fields()) : ?>

                                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                                <div class="row" id="customer_details">
                                    <div class="col-12">
                                        <?php do_action('woocommerce_checkout_billing'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php do_action('woocommerce_checkout_shipping'); ?>
                                    </div>
                                </div>

                                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                            <?php endif; ?>

                            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_order_review'); ?>

                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="new-checkout__info">
                        <?php
                        if (wc_coupons_enabled()): ?>
                        <div class="woocommerce-form-coupon-toggle">
                            <p>У вас есть купон? <a href="#" class="showcoupon">Нажмите здесь для введения кода</a></p>
                        </div>

                        <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

                            <div class="input-group">
                                <input type="text" name="coupon_code" class="input-text"
                                       placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>"
                                       id="coupon_code" value=""/>
                                <div class="input-group-append">
                                    <button type="submit" class="button" name="apply_coupon"
                                            value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">Применить</button>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </form>
                        <?php endif; ?>
                        <p>Нажимая кнопку “Перейти к оплате” вы даете согласие на обработку
                            своих
                            персональных данных.</p>
                        <p>Для оплаты вы будете перенаправлены на страницу сервиса
                            Яндекс.Кассы,
                            где
                            сможете безопасно провести платеж.</p>
                        <p>После того, как будет произведена оплата, вам на почту придет
                            письмо,
                            в
                            котором будет находиться ссылка на скачивание, а также пароль от личного кабинета.
                        </p>
                        <p>В личном кабинете вам будет доступна информация о приобретенных
                            книгах, а
                            также постоянный дотуп к их загрузке.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
