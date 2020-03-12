<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
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

if (!comments_open()) {
    return;
}

$category = get_the_category($post->ID);
$slug = $category[0]->slug; // try print_r($category); to see everything

var_dump($category);
?>

<div class="row">
    <div id="reviews" class="woocommerce-Reviews col-lg-6 col-12">
        <div id="comments">
            <?php if (have_comments()) : ?>
                <img class="comments__img" src="/wp-content/themes/storefront-child/svg/svg-review.svg"
                     alt="reviews">

                <div class="slider-container">
                    <div id="carouselReviews" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'mytheme_comment'))); ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>

        <div class="clear"></div>
    </div>

<!--    <div class="col-lg-6 col-12 new-related">-->
<!--        --><?php
//        $args = array(
//            'status' => 'publish',
//            'category' => $cat,
//            'limit' => 4,
//        );
//        $query = new WC_Product_Query($args);
//        $products = $query->get_products();
//        foreach ($products as $product):
//            ?>
<!--            <div class="col-3">-->
<!--                <div class="popular-block-card">-->
<!--                    <a href="--><?php //echo $product->get_permalink(); ?><!--">-->
<!--                        <div class="popular-block-card__img">-->
<!--                            --><?php //echo $product->get_image('medium'); ?>
<!--                        </div>-->
<!--                        <p class="popular-block-card__title">--><?php //echo $product->get_name(); ?><!--</p>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php //endforeach; ?>
<!--    </div>-->
</div>
