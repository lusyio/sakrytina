<?php
/*
Template Name: bibliography
Template Post Type: post, page, product
*/
?>

<?php get_header(); ?>


<div class="container bibliography">
    <div class="row">
        <div class="col-6">
            <h1 class="bibliography__header">Библиография</h1>
            <p class="bibliography__info">Я эксклюзивный автор «Литнета», это значит, что мои книги можно
                прочитать/скачать онлайн на этом портале. Также 3 моих романа (“Слушаю и повинуюсь», «Никаких принцев!»
                и «Не хочу жениться!»)</p>
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

                $yearTerms[] = (int) $book_year;

            }
            $yearTerms = array_unique($yearTerms);
            sort($yearTerms);

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
                    <div class="col-1 mb-auto" style="margin-top: 6.5%;"><p
                                class="bibliography__year"><?= $yearNumber ?></p></div>
                    <div class="col bibliography__border">
                        <?php
                        $i = 0;
                        foreach ($products as $sortedProd):

                            // id продукта
                            $idBook = $sortedProd->get_id();

                            // год издания
                            $book_year = (get_post_meta($idBook, 'book_year', true));

                            // сравниванием года
                        
                            if($yearNumber==$book_year) :
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
                                <div class="col-1 m-auto">
                                    <?php if ($yearNumber && $i === 0): ?>
                                        <img class="bibliography__img" src="/wp-content/themes/storefront-child/svg/svg-point.svg" alt="point">
                                    <?php else: ?>
                                        <img class="bibliography__img" src="/wp-content/themes/storefront-child/svg/svg-point-outline.svg"
                                             alt="point">
                                    <?php endif; ?>
                                </div>
                                <div class="col-2">
                                    <a href="<?= $sortedProd->get_permalink() ?>">
                                        <div class="bibliography__thumbnail">
                                            <img alt="<?= $sortedProd->name ?>"
                                                 src="<?=$imgsrc;?>"/>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 bibliography__card">
                                    <div>
                                        <p class="bibliography__title"><a href="<?= $sortedProd->get_permalink() ?>"><?= $sortedProd->name ?></a></p>
                                        <hr>
                                        <p class="bibliography__genre"><?php foreach ($tagNameList as $key => $genre) {
                                                echo $genre;
                                                echo (count($tagNameList) - 1 !== $key) ? ', ' : '';
                                            } ?></p>
                                        <p class="bibliography__cycle"><a href="<?= $linkCat ?>"><?=$catName;?></a></p>
                                    </div>
                                </div>
                                <div class="col-3 mt-auto mb-auto">
                                    <?php if(!empty($award)) :
                                        ?>
                                        <div class="bibliography__award">
                                            <img src="/wp-content/themes/storefront-child/images/img-award-bibl.png"
                                                 alt="award">
                                            <p><?=$award;?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php
                            $tagNameList = array();
                            $i++;
endif;
                            endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>
