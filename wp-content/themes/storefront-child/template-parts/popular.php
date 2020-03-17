<div class="popular-block">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <p class="popular-block__header">Популярное</p>
                <div class="row">
                    <?php
                    $args = array(
                        'status' => 'publish',
                        'orderby' => 'order_clause',
                        'order' => 'DESC',
                        'meta_query' => array(
                            'order_clause' => array(
                                'key' => 'total_sales',
                                'value' => 'some_value',
                                'type' => 'NUMERIC' // unless the field is not a number
                            )),
                        'limit' => 4,
                    );
                    $query = new WC_Product_Query($args);
                    $products = $query->get_products();
                    foreach ($products as $product):
                        ?>
                        <div class="col-3">
                            <div data-active="<?= $product->slug ?>" class="popular-block-card">
                                <a href="<?php echo $product->get_permalink(); ?>">
                                    <div class="popular-block-card__img">
                                        <?php echo $product->get_image('medium'); ?>
                                    </div>
                                    <p class="popular-block-card__title"><?php echo $product->get_name(); ?></p>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="carouselHover" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        foreach ($products as $product): ?>
                            <div id="<?= $product->slug ?>" class="popular-hover-card carousel-item">
                                <div class="popular-hover-card__body">
                                    <div class="popular-hover-card__img">
                                        <?php echo $product->get_image('medium'); ?>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="popular-hover-card__info">
                                            <p class="popular-hover-card__title"><?php echo $product->get_name(); ?></p>
                                            <p class="popular-hover-card__author">Мария Сакрытина</p>
                                            <?php $desc = strip_tags($product->get_short_description());
                                            if ($desc):?>
                                                <p class="popular-hover-card__desc-header">Аннотация</p>
                                                <p class="popular-hover-card__desc">
                                                    <?php
                                                    $size = 240;
                                                    echo mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                                    echo (strlen($desc) > $size) ? '...' : '';
                                                    ?></p>
                                            <?php endif; ?>
                                            <a href="<?= $product->get_permalink(); ?>"
                                               class="btn btn-primary">Подробнее</a>
                                        </div>
                                        <div>
                                            <?php
                                            $tags = get_the_terms($product->get_id(), 'product_tag');
                                            if ($tags):
                                                ?>
                                                <div class="popular-hover-card__award">
                                                    <img src="/wp-content/themes/storefront-child/images/img-award.jpg"
                                                         alt="award">
                                                    <?php
                                                    foreach ($tags as $tag) {
                                                        $tagNameList[] = $tag->name;
                                                    }
                                                    ?>
                                                    <p><?php foreach ($tagNameList as $name) echo $name ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                            $genreTerms = get_the_terms($product->get_id(), 'pa_genre');
                                            $categoryTerms = get_the_terms($product->get_id(), 'pa_book_category');
                                            ?>
                                            <?php if ($categoryTerms): ?>
                                                <p class="popular-hover-card__meta-title">Категории:</p>
                                                <p class="popular-hover-card__meta-content">
                                                    <?php foreach ($categoryTerms as $key => $category) {
                                                        echo $category->name;
                                                        echo (count($categoryTerms) - 1 !== $key) ? ', ' : '';
                                                    } ?>
                                                </p>
                                            <?php endif; ?>
                                            <p class="popular-hover-card__meta-title">Серия:</p>
                                            <p class="popular-hover-card__meta-content"><?php echo wc_get_product_category_list($product->get_id(), ', ', '' . _n('', '', count($product->get_category_ids()), 'woocommerce') . ' ', ''); ?></p>
                                            <div class="popular-hover-card__variables">
                                                <?php
                                                $variables = get_the_terms($product->get_id(), 'pa_book_type');
                                                if ($variables):
                                                    foreach ($variables as $variable) {
                                                        $variablesSlugList[] = $variable->slug;
                                                    }
                                                    ?>
                                                    <?php foreach ($variablesSlugList as $slug): ?>
                                                    <?php if ($slug === 'elektronnaya-kniga'): ?>
                                                        <img src="/wp-content/themes/storefront-child/svg/svg-ebook.svg"
                                                             alt="<?= $slug ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                    <img src="/wp-content/themes/storefront-child/svg/svg-book.svg"
                                                         alt="book">
                                                    <?php foreach ($variablesSlugList as $slug): ?>
                                                    <?php if ($slug === 'audiokniga'): ?>
                                                        <img src="/wp-content/themes/storefront-child/svg/svg-audio.svg"
                                                             alt="<?= $slug ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>


                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-next" href="#carouselHover" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <?php
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>