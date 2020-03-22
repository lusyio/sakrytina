<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $post;
global $product;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

if ($short_description) :
    ?>
    <div class="woocommerce-product-details__short-description">
        <?php echo $short_description; // WPCS: XSS ok.
        ?>
    </div>
<?php endif; ?>
<?php
// ссылка на ознакомительный фрагмент
$link = (get_post_meta($post->ID, 'read_fragment_link', true));
if (!!$link): ?>
    <div class="fragment-link">
        <a target="_blank" href="<?= $link; ?>">
            <img src="/wp-content/themes/storefront-child/svg/svg-read-fragment.svg"
                 alt="read-fragment">
            Читать фрагмент
        </a>
    </div>
<?php endif; ?>
