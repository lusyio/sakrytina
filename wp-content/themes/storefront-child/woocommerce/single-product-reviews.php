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

$terms = get_the_terms($product->get_id(), 'product_cat');

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

    <div class="col-lg-6 col-12 new-related">

        <?php
        $args = array(
            'status' => 'publish',
            'category' => $terms[0]->slug,
            'limit' => 4,
        );
        $query = new WC_Product_Query($args);
        $products = $query->get_products();
        $i = 0;
        ?>
        <div id="carouselRelated" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carouselRelated-control">
                <a class="carousel-books-control-prev" href="#carouselRelated" role="button"
                   data-slide="prev">
                    <img src="/wp-content/themes/storefront-child/svg/svg-prev.svg" alt="prev">
                </a>
                <a class="carousel-books-control-next" href="#carouselRelated" role="button"
                   data-slide="next">
                    <img src="/wp-content/themes/storefront-child/svg/svg-next.svg" alt="next">
                </a>
            </div>
            <div class="carousel-inner">
                <?php foreach ($products
                               as $product):
                    ?>
                    <div class="new-related__card carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <div class="new-related__card-body">
                            <div>
                                <div class="new-related__img">
                                    <?= $product->get_image('medium'); ?>
                                </div>
                                <div>
                                    <p class="new-related__cycle">Книги из этого цикла</p>
                                    <p class="new-related__title"><?php
                                        $title = $product->get_name();
                                        echo mb_substr($title, 0, mb_strrpos(mb_substr($title, 0, 22, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                        echo (strlen($title) > 22) ? '...' : '';
                                         ?>
                                    </p>
                                    <p class="new-related__text">
                                        <?php
                                        $desc = strip_tags($product->get_short_description());
                                        $size = 240;
                                        echo mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                        echo (strlen($desc) > $size) ? '...' : '';
                                        ?>
                                    </p>
                                    <a class="btn btn-primary" href="<?= $product->get_permalink(); ?>">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                endforeach; ?>
            </div>
        </div>
    </div>
</div>
