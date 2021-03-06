<?php
/*
Template Name: bibliography
Template Post Type: post, page, product
*/
?>

<?php get_header(); ?>


<div class="container bibliography">
    <div class="row">
        <div class="col-md-6 col-12 bibliography__info">
            <h1 class="bibliography__header text-center text-md-left">Библиография</h1>
            <?= the_content(); ?>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12">
            <?php
            $query = new WC_Product_Query(array(
                'limit' => -1,
            ));

            // получаем массив с продуктами
            $products = $query->get_products();

            // собираем года

            foreach ($products as $product) {

                // id продукта
                $idBook = $product->get_id();

                $book_year = (get_post_meta($idBook, 'book_year', true));

                $yearTerms[] = (int)$book_year;

            }
            $yearTerms = array_unique($yearTerms);
            sort($yearTerms);
            $countBLock = 1;

            foreach (array_reverse($yearTerms) as $yearNumber):
                $args = array(
                    'limit' => -1,
                    'tax_query' => array(array(
                        'taxonomy' => 'pa_year_publication',
                        'field' => 'name',
                        'terms' => strval($yearNumber),
                        'operator' => 'IN',
                    ))
                );
                $loop = new WC_Product_Query($args);
                $sortedProducts = $loop->get_products();
                ?>
                <div class="row">
                    <div class="col-lg-1 col-md-3 col-4 bibliography__years  mb-auto wow fadeIn" data-wow-duration="1s"><p
                                class="bibliography__year"><img class="d-lg-none d-inline-block" src="/wp-content/themes/storefront-child/svg/svg-point.svg"
                                                                 alt="point"> <?= $yearNumber ?></p></div>

                    <div class="col-lg-11 col-12 bibliography__border <?php if ($countBLock == 1) : echo 'bibliography__border1'; endif; ?>">

                        <?php
                        $i = 0;
                        foreach ($products as $sortedProd):

                            // id продукта
                            $idBook = $sortedProd->get_id();

                            // год издания
                            $book_year = (get_post_meta($idBook, 'book_year', true));

                            // публикуется только в библиографии?
                            $bibl_only = (get_post_meta($idBook, 'only_bibli', true));


                            // сравниванием года

                            if ($yearNumber == $book_year) :


                                // получаем картинку
                                $imgsrc = wp_get_attachment_url($sortedProd->get_image_id());
                                if (empty($imgsrc)) :
                                    $imgsrc = '/wp-content/uploads/woocommerce-placeholder.png';
                                endif;

                                // жанры
                                $tags = get_the_terms($idBook, 'product_tag');
                                foreach ($tags as $tag) {
                                    $tagNameList[] = $tag->name;
                                }

                                // цикл
                                $catTerms = get_the_terms($idBook, 'product_cat');
                                foreach ($catTerms as $key => $term):
                                    $catName = $term->name;
                                    $linkCat = '/shop/#' . $term->slug;
                                endforeach;

                                // награда
                                $award = (get_post_meta($idBook, 'award', true));


                                ?>
                                <div class="row bibliography__row">
                                    <div class="col-1 d-lg-block d-none m-auto wow fadeIn">
                                        <?php if ($yearNumber && $i === 0): ?>
                                            <img class="bibliography__img"
                                                 src="/wp-content/themes/storefront-child/svg/svg-point.svg"
                                                 alt="point">
                                        <?php else: ?>
                                            <img class="bibliography__img"
                                                 src="/wp-content/themes/storefront-child/svg/svg-point-outline.svg"
                                                 alt="point">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-4">
                                        <div class="bibliography__thumbnail wow fadeIn">

                                            <?php if ($bibl_only != 1) : ?><a
                                                    href="<?= $sortedProd->get_permalink() ?>"><?php endif;
                                                ?>

                                                <img class="wow fadeIn" data-wow-delay="0.2s"
                                                     alt="<?= $sortedProd->name ?>"

                                                     src="<?= $imgsrc; ?>"/>
                                                <?php if ($bibl_only != 1) : ?></a><?php endif; ?>
                                            <?php  if (!empty($award)) :
                                                ?>
                                                <div class="bibliography__thumbnail-award d-lg-none d-block">
                                                    <img class="wow fadeIn" data-wow-delay="1s"
                                                         src="/wp-content/themes/storefront-child/images/img-award-bibl.png"
                                                         alt="award">
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-5 col-md-9 col-8 bibliography__card">
                                        <div>
                                            <p class="bibliography__title wow fadeInUp" data-wow-delay="0.2s">
                                                <?php if ($bibl_only != 1) : ?>
                                                    <a
                                                            href="<?= $sortedProd->get_permalink() ?>"><?= $sortedProd->name ?></a>
                                                <?php else :
                                                    echo $sortedProd->name; endif; ?>
                                            </p>
                                            <hr class="d-lg-block d-none">
                                            <p class="bibliography__genre wow fadeInUp"
                                               data-wow-delay="0.3s"><?php foreach ($tagNameList as $key => $genre) {
                                                    echo $genre;
                                                    echo (count($tagNameList) - 1 !== $key) ? ', ' : '';
                                                } ?></p>
                                            <p class="bibliography__cycle wow fadeInUp" data-wow-delay="0.4s">
                                                <?php if ($bibl_only != 1) : ?>
                                                    <a href="<?= $linkCat ?>"><?= $catName; ?></a>
                                                <?php else :
                                                    echo $catName; endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 d-lg-block d-none mt-auto mb-auto">
                                        <?php
                                        if (!empty($award)) :
                                            ?>
                                            <div class="bibliography__award">

                                                <img class="wow fadeIn" data-wow-delay="1s"
                                                     src="/wp-content/themes/storefront-child/images/img-award-bibl.png"
                                                     alt="award">
                                                <div class="wow fadeIn" data-wow-delay="1s"><p><?= $award; ?></p></div>


                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php
                                $tagNameList = array();
                                $i++;
                                $countBLock++;
                            endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>
