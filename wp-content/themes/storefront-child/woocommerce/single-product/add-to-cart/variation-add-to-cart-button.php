<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;
$is_in_cart = false;

foreach (WC()->cart->get_cart() as $cart_item)
    if ($cart_item['product_id'] == $product->get_id()) {
        $is_in_cart = true;
        break;
    }

if ($is_in_cart)
    $button_text = __('Уже в корзине', 'woocommerce');

?>
<?php if ($is_in_cart): ?>
    <a class="btn btn-primary" href="/cart/">Уже в корзине</a>
<?php else: ?>
    <div class="woocommerce-variation-add-to-cart variations_button">
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <button type="submit"
                class="btn btn-primary single_add_to_cart_button"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>

        <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
        <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
    </div>
<?php endif; ?>

