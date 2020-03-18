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
            $products = $query->get_products();
            foreach ($products as $product) {
                $yearTerms = get_the_terms($product->get_id(), 'pa_year_publication');
                foreach ($yearTerms as $key => $year) {
                    $yearNumbers[(int)$year->name] = (int)$year->name;
                    asort($yearNumbers);
                }
            }
            foreach (array_reverse($yearNumbers) as $yearNumber):
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
                    <div class="col-1 mb-auto" style="margin-top: 7.5%;"><p
                                class="bibliography__year"><?= $yearNumber ?></p></div>
                    <div class="col bibliography__border">
                        <?php
                        $i = 0;
                        foreach ($sortedProducts as $sortedProd): ?>
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
                                                 src="<?php echo wp_get_attachment_url($sortedProd->get_image_id()); ?>"/>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 bibliography__card">
                                    <div>
                                        <p class="bibliography__title"><?= $sortedProd->name ?></p>
                                        <hr>
                                        <?php
                                        $genreTerms = get_the_terms($sortedProd->get_id(), 'pa_genre');
                                        ?>
                                        <p class="bibliography__genre"><?php foreach ($genreTerms as $key => $genre) {
                                                echo $genre->name;
                                                echo (count($genreTerms) - 1 !== $key) ? ', ' : '';
                                            } ?></p>
                                        <p class="bibliography__cycle"><?php echo wc_get_product_category_list($product->get_id(), ', ', '' . _n('', '', count($product->get_category_ids()), 'woocommerce') . ' ', ''); ?></p>
                                    </div>
                                </div>
                                <div class="col-3 mt-auto mb-auto">
                                    <?php
                                    $tags = get_the_terms($sortedProd->get_id(), 'product_tag');

                                    if ($tags):
                                        ?>
                                        <div class="bibliography__award">
                                            <img src="/wp-content/themes/storefront-child/images/img-award-bibl.png"
                                                 alt="award">
                                            <?php
                                            foreach ($tags as $tag) :?>
                                                <p><?= $tag->name ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php $i++; endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>
