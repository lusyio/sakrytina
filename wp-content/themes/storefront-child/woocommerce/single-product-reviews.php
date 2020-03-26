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
//    return;
}

$terms = get_the_terms($product->get_id(), 'product_cat');

?>

<?php if (have_comments()) : ?>

<div id="reviews" class="woocommerce-Reviews col-lg-6 col-12">
    <div id="comments">
        <img class="comments__img" src="/wp-content/themes/storefront-child/svg/svg-review.svg"
             alt="reviews">
        <div class="slider-container">
            <div id="carouselReviews" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'mytheme_comment'))); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="col-lg-6 col-12 new-related">
    <?php else: ?>
    <div class="col-lg-12 col-12 new-related new-related__row">
        <?php endif; ?>
        <?php
        // Делаем запрос на 4 книги этой же категории, кроме текущей и тех, которые только для библиографии
        $args = [
            'status' => 'publish',
            'category' => $terms[0]->slug,
            'limit' => 4,
            'exclude' => array($product->get_id()),
            'meta_query' => [
                [
                    'key' => 'only_bibli',
                    'compare' => '!=',
                    'value' => '1',
                ]
            ],
        ];

        $query = new WC_Product_Query($args);
        $products = $query->get_products();
        $relatedProducts = $products;
        // Если в результате запроса меньше 4 книг, то делаем новый запрос
        $inCategoryCount = count($products);
        if ($inCategoryCount < 4) {
            // создаем массив с id текущей книги и уже полученных книг, чтобы исключить их при запросе
            $notIn = [$product->get_id()];
            foreach ($relatedProducts as $relatedProduct) {
                $notIn[] = $relatedProduct->get_id();
            }
            $limit = 4 - $inCategoryCount;
            $args = array(
                'status' => 'publish',
                'limit' => $limit,
                'exclude' => $notIn,
                'orderby' => 'rand',
                'meta_query' => [
                    [
                        'key' => 'only_bibli',
                        'compare' => '!=',
                        'value' => '1',
                    ]
                ],
            );
            $secondRelatedQuery = new WC_Product_Query($args);
            $secondRelatedProducts = $secondRelatedQuery->get_products();
            // Добавляем результаты второго запроса в общий результат
            foreach ($secondRelatedProducts as $secondRelatedProduct) {
                $relatedProducts[] = $secondRelatedProduct;
            }
        }
        $i = 0;
        ?>
        <div id="carouselRelated" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="d-lg-block d-none carouselRelated-control">
                <a class="carousel-books-control-prev" href="#carouselRelated" role="button"
                   data-slide="prev">
                    <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.292891 8.70711C-0.097633 8.31658 -0.097633 7.68342 0.292891 7.29289L6.65685 0.928932C7.04738 0.538408 7.68054 0.538408 8.07107 0.928932C8.46159 1.31946 8.46159 1.95262 8.07107 2.34315L2.41421 8L8.07107 13.6569C8.46159 14.0474 8.46159 14.6805 8.07107 15.0711C7.68054 15.4616 7.04738 15.4616 6.65685 15.0711L0.292891 8.70711ZM31 9H0.999998V7H31V9Z"
                              fill="#B9B9B9"/>
                    </svg>
                </a>
                <a class="carousel-books-control-next" href="#carouselRelated" role="button"
                   data-slide="next">
                    <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z"
                              fill="#B9B9B9"/>
                    </svg>
                </a>
            </div>
            <div class="carousel-inner">
                <?php foreach ($relatedProducts
                               as $key => $relatedProduct):
                    ?>
                    <?php if (have_comments() || $i % 2 == 0): ?>
                    <div class="new-related__card carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row">
                <?php endif; ?>
                    <div class="<?php echo (!have_comments()) ? 'col-lg-6 new-related__mt' : 'new-related__mt' ?>">
                        <div class="new-related__card-body ">
                            <div>
                                <div class="new-related__img">
                                    <?= $relatedProduct->get_image('medium'); ?>
                                </div>
                                <div>
                                    <?php if ($key < $inCategoryCount): ?>
                                        <p class="new-related__cycle">Книги из этого цикла</p>
                                    <?php else: ?>
                                        <p class="new-related__cycle">Рекомендуем</p>
                                    <?php endif; ?>
                                    <p class="new-related__title"><?php
                                        $title = $relatedProduct->get_name();
                                        echo (mb_strlen($title) > 22) ? mb_substr($title, 0, mb_strrpos(mb_substr($title, 0, 22, 'utf-8'), ' ', 0, 'utf-8'), 'utf-8') . '...' : $title;
                                        ?>
                                    </p>
                                    <p class="new-related__text">
                                        <?php
                                        $desc = strip_tags($relatedProduct->get_short_description());
                                        $size = 240;
                                        echo mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                        echo (strlen($desc) > $size) ? '...' : '';
                                        ?>
                                    </p>
                                    <a class="btn btn-primary"
                                       href="<?= $relatedProduct->get_permalink(); ?>">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (have_comments() || $i % 2 == 1): ?>
                    </div>
                    </div>
                <?php endif; ?>
                    <?php
                    $i++;
                endforeach; ?>
            </div>
            <div class="d-lg-none d-block carouselRelated-control">
                <a class="carousel-books-control-prev" href="#carouselRelated" role="button"
                   data-slide="prev">
                    <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.292891 8.70711C-0.097633 8.31658 -0.097633 7.68342 0.292891 7.29289L6.65685 0.928932C7.04738 0.538408 7.68054 0.538408 8.07107 0.928932C8.46159 1.31946 8.46159 1.95262 8.07107 2.34315L2.41421 8L8.07107 13.6569C8.46159 14.0474 8.46159 14.6805 8.07107 15.0711C7.68054 15.4616 7.04738 15.4616 6.65685 15.0711L0.292891 8.70711ZM31 9H0.999998V7H31V9Z"
                              fill="#B9B9B9"/>
                    </svg>
                </a>
                <a class="carousel-books-control-next" href="#carouselRelated" role="button"
                   data-slide="next">
                    <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z"
                              fill="#B9B9B9"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
