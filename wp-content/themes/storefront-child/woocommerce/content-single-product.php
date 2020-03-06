<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div class="row" id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action('woocommerce_before_single_product_summary');
    ?>

    <div class="col-lg-9 pl-lg-0 pl-unset col-12 ">
        <div class="product-card">
            <div class="row">
                <div class="col-lg-8 pr-lg-0 pr-unset col-12 br">
                    <div class="product-card__main-body">
                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary.
                         *
                         * @hooked woocommerce_template_single_title - 5
                         * @hooked woocommerce_template_single_rating - 10
                         * @hooked woocommerce_template_single_price - 10
                         * @hooked woocommerce_template_single_excerpt - 20
                         * @hooked woocommerce_template_single_add_to_cart - 30
                         * @hooked woocommerce_template_single_meta - 40
                         * @hooked woocommerce_template_single_sharing - 50
                         * @hooked WC_Structured_Data::generate_product_data() - 60
                         */
                        do_action('woocommerce_single_product_summary');
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 col-12 pl-lg-0 pl-unset">
                    <div class="product-card__secondary-body">
                        <?php
                        $tags = get_the_terms($product->get_id(), 'product_tag');
                        if ($tags):
                            ?>
                            <div class="product-card__award">
                                <img src="/wp-content/themes/storefront-child/images/img-award.jpg" alt="award">
                                <?php
                                foreach ($tags as $tag) {
                                    $tagNameList[] = $tag->name;
                                }
                                ?>
                                <p><?php foreach ($tagNameList as $name) echo $name ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="product-card__meta">
                            <?php
                            $genreTerms = get_the_terms($product->get_id(), 'pa_genre');
                            $yearTerms = get_the_terms($product->get_id(), 'pa_year_publication');
                            $timeTerms = get_the_terms($product->get_id(), 'pa_reading_time');
                            ?>
                            <?php if ($genreTerms): ?>
                                <p class="product-card__meta-title">Жанр:</p>
                                <p class="product-card__meta-content">
                                    <?php foreach ($genreTerms as $key => $genre) {
                                        echo $genre->name;
                                        echo (count($genreTerms) - 1 !== $key) ? ', ' : '';
                                    } ?>
                                </p>
                            <?php endif; ?>
                            <p class="product-card__meta-title">Серия:</p>
                            <p class="product-card__meta-content"><?php echo wc_get_product_category_list($product->get_id(), ', ', '' . _n('', '', count($product->get_category_ids()), 'woocommerce') . ' ', ''); ?></p>
                            <?php if ($yearTerms): ?>
                                <p class="product-card__meta-title">Год издания:</p>
                                <p class="product-card__meta-content">
                                    <?php foreach ($yearTerms as $key => $year) {
                                        echo $year->name;
                                    } ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($timeTerms): ?>
                                <p class="product-card__meta-title">Время чтения:</p>
                                <p class="product-card__meta-content">
                                    <?php foreach ($timeTerms as $key => $time) {
                                        echo $time->name;
                                    } ?>
                                </p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
