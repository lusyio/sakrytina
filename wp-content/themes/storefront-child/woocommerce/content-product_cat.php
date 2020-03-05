<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
/**
 * woocommerce_shop_loop_subcategory_title hook.
 *
 * @hooked woocommerce_template_loop_category_title - 10
 */
do_action('woocommerce_shop_loop_subcategory_title', $category);

if ($category->count > 3):
    ?>
    <div id="carousel<?= $category->slug ?>" class="carousel carousel-books slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php $i = 0; ?>
            <div class="carousel-item active">
                <?php
                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        global $product;

                        foreach ($product->category_ids as $category_id) {
                            $cat_id = $category_id;
                        }

                        if ($cat_id === $category->term_id) {
                            wc_get_template_part('content', 'product');
                            $i++;
                        }

                        if ($i === 3) {
                            echo '</div>';
                            echo '<div class="carousel-item">';
                            $i = 0;
                        }

                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex">
        <?php
        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                global $product;

                foreach ($product->category_ids as $category_id) {
                    $cat_id = $category_id;
                }

                if ($cat_id === $category->term_id) {
                    echo '<div class="carousel-books">';
                    wc_get_template_part('content', 'product');
                    echo '</div>';
                }

            }
        }
        ?>
    </div>
<?php endif; ?>