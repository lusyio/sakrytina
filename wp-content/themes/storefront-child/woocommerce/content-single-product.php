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


// получение данных о книге
$idBook = $product->get_id();

// жанры
$tags = get_the_terms($idBook, 'product_tag');
foreach ($tags as $tag) {
    $tagNameList[] = $tag->name;
}

// серия
$catTerms = get_the_terms($idBook, 'product_cat');
foreach ($catTerms as $key => $term):
    $catName = $term->name;
    $linkCat = '/shop/#' . $term->slug;
endforeach;

$typeName = 'Цикл';
if ($catName == 'Сборник рассказов') :
    $typeName = 'Тип';
endif;

// год издания
$book_year = (get_post_meta($idBook, 'book_year', true));

// количество симоволов
$count_simvolov = (get_post_meta($idBook, 'count_simvolov', true));
$hours = ceil(($count_simvolov/1000)/60);

$timeToRead = $hours . ' часов ('.$count_simvolov.' символов)';
// награда
$award = (get_post_meta($idBook, 'award', true));

// ссылка на ознакомительный фрагмент
$read_fragment_link = (get_post_meta($idBook, 'read_fragment_link', true));

// ссылки на бумажные книги

// Ozon
$ozon_link = (get_post_meta($idBook, 'ozon_link', true));

// Лабиринт
$labirint_link = (get_post_meta($idBook, 'labirint_link', true));

// Book24
$book24_link = (get_post_meta($idBook, 'book24_link', true));

// Читай-город
$chitai_gorod_link = (get_post_meta($idBook, 'chitai_gorod_link', true));

// Буквоед
$bukvoed_link = (get_post_meta($idBook, 'bukvoed_link', true));

// Автограф
$avtograf2014_link = (get_post_meta($idBook, 'avtograf2014_link', true));

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

                        // вывод награды

                        if (!empty($award)) :?>
                            <div class="product-card__award">
                                <img src="/wp-content/themes/storefront-child/images/img-award.jpg" alt="award">
                                <p><?= $award; ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="product-card__meta">
                            <?php

                            // вывод жанров

                            if ($tagNameList): ?>
                                <p class="product-card__meta-title">Жанр<?=(count($tagNameList) > 1) ? 'ы' : '';?>:</p>
                                <p class="product-card__meta-content">
                                    <?php foreach ($tagNameList as $key => $genre) {
                                        echo $genre;
                                        echo (count($tagNameList) - 1 !== $key) ? ', ' : '';
                                    } ?>
                                </p>
                                <p>
                            <?php endif; ?>
                            <?php

                            // вывод циклп

                            if (!empty($catName)) :?>
                                <p class="product-card__meta-title"><?=$typeName;?>:</p>
                                <p class="product-card__meta-content"><a href="<?= $linkCat ?>"><?=$catName;?></a></p>
                            <?php endif; ?>

                            <?php

                            // вывод года издания

                            if (!empty($book_year)) :?>
                                <p class="product-card__meta-title">Год издания:</p>
                                <p class="product-card__meta-content"><?=$book_year;?></p>
                            <?php endif; ?>

                            <?php

                            // вывод времени чтения

                            if (!empty($count_simvolov)) :?>
                                <p class="product-card__meta-title">Время чтения:</p>
                                <p class="product-card__meta-content"><?=$timeToRead;?></p>
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
