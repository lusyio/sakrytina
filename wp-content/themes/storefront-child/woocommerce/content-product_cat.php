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
$productCount = 0;
//var_dump($category->count);
//var_dump($category);
global $wp_query;
$params = array(
    'posts_per_page' => -1,
    'meta_key' => 'only_bibli',
    'meta_value' => '1',
    'meta_compare' => '!=',
);
$params = array_merge( $wp_query->query, $params );
query_posts( $params );
$booksInResult = $wp_query->posts;
$booksInCategory = post_id_by_term_id($category->term_id);
foreach ($booksInResult as $book) {
    if (in_array($book->ID, $booksInCategory)) {
        $productCount++;
    }
}
if ($productCount == 0) {
    if (!isset($GLOBALS['emptyCategories'])) {
        $GLOBALS['emptyCategories'] = [];
    }
    $GLOBALS['emptyCategories'][] = $category->slug;
    return;
}
?>
<?php
/**
 * woocommerce_shop_loop_subcategory_title hook.
 *
 * @hooked woocommerce_template_loop_category_title - 10
 */
do_action('woocommerce_shop_loop_subcategory_title', $category);



if ($productCount > 3):
    $j = 0;
    ?>
    <div id="<?= $category->slug ?>" class="swiper-container carousel-books" data-ride="carousel">
        <div class="swiper-wrapper">
            <?php $i = 0; ?>
            <div class="swiper-slide">
                <?php
                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();
                        if (get_post_meta(get_the_ID(), 'only_bibli',true) == 1) {
                            continue;
                        }
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
                            $j++;
                        }

                        if ($i === 1) {
                            if ($category->count !== $j){
                                echo '</div>';
                                echo '<div class="swiper-slide">';
                            }
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
                if (get_post_meta(get_the_ID(), 'only_bibli',true) == 1) {
                    continue;
                }
                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                global $product;

                foreach ($product->category_ids as $category_id) {
                    $cat_id = $category_id;
                }

                if ($cat_id === $category->term_id) {
                    echo '<div class="carousel-books carousel-books__single">';
                    wc_get_template_part('content', 'product');
                    echo '</div>';
                }

            }
        }
        ?>
    </div>
<?php endif; ?>