<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<?php if ($gateway->id === 'cod'): ?>
    <li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?>">
        <label for="">
            <label class="pure-material-radio w-100">
                <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio"
                       name="payment_method"
                       value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?>
                       data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>"/>
                <span> PayPal<img src="https://www.paypalobjects.com/webstatic/ru_RU/mktg/business/pages/logo-center/AM_mc_vs_dc_ae.jpg"
                   alt="paypal"></span>
            </label>
        </label>
    </li>
<?php else: ?>
<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?>">
    <label for="">
        <label class="pure-material-radio w-100">
            <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio"
                   name="payment_method"
                   value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?>
                   data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>"/>
            <span>
        <?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?><?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
    </span>
        </label>
    </label>
</li>
<?php endif;
