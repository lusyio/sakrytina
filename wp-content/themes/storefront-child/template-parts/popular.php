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
                                    <p class="popular-block-card__title"><?php
                                        $title = $product->get_name();
                                        echo mb_substr($title, 0, mb_strrpos(mb_substr($title, 0, 27, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                        echo (strlen($title) > 27) ? '...' : '';
                                        ?></p>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="carouselHover" data-interval="false" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        foreach ($products as $product): ?>
                            <div id="<?= $product->slug ?>" class="popular-hover-card carousel-item">
                                <div class="popular-hover-card__body">
                                    <div class="popular-hover-card__img wow fadeInUp" data-wow-delay="0.2s">
                                        <?php $attachment_ids = $product->get_gallery_image_ids();
                                        foreach ($attachment_ids as $attachment_id): ?>
                                            <img src="<?= wp_get_attachment_image_src($attachment_id, 'full')[0] ?>"
                                                 alt="">
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="popular-hover-card__info">
                                            <p class="popular-hover-card__title wow fadeInUp"
                                               data-wow-delay="0.4s"><?php
                                                $title = $product->get_name();
                                                echo mb_substr($title, 0, mb_strrpos(mb_substr($title, 0, 22, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                                echo (strlen($title) > 22) ? '...' : '';
                                                ?></p>
                                            <p class="popular-hover-card__author wow fadeInUp" data-wow-delay="0.5s">
                                                Мария Сакрытина</p>
                                            <?php $desc = strip_tags($product->get_short_description());
                                            if ($desc):?>
                                                <p class="popular-hover-card__desc-header wow fadeInUp"
                                                   data-wow-delay="0.6s">Аннотация</p>
                                                <p class="popular-hover-card__desc wow fadeInUp" data-wow-delay="0.6s">
                                                    <?php
                                                    $size = 240;
                                                    echo mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                                    echo (strlen($desc) > $size) ? '...' : '';
                                                    ?></p>
                                            <?php endif; ?>
                                            <a href="<?= $product->get_permalink(); ?>"
                                               class="btn btn-primary wow fadeInUp" data-wow-delay="2s">Подробнее</a>
                                        </div>
                                        <div class="popular-hover-card__meta">
                                            <?php
                                            $tags = get_the_terms($product->get_id(), 'product_tag');
                                            if ($tags):
                                                ?>
                                                <div class="popular-hover-card__award wow fadeInUp"
                                                     data-wow-delay="0.8s">
                                                    <img src="/wp-content/themes/storefront-child/images/img-award.jpg"
                                                         alt="award">
                                                    <?php foreach ($tags as $tag) : ?>
                                                        <p><?= $tag->name ?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                            $genreTerms = get_the_terms($product->get_id(), 'pa_genre');
                                            $categoryTerms = get_the_terms($product->get_id(), 'pa_book_category');
                                            $catTerms = wp_get_post_terms($product->get_id(), 'product_cat')
                                            ?>
                                            <?php if ($categoryTerms): ?>
                                                <p class="popular-hover-card__meta-title wow fadeInUp"
                                                   data-wow-delay="1s">Категории:</p>
                                                <p class="popular-hover-card__meta-content wow fadeInUp"
                                                   data-wow-delay="1s">
                                                    <?php foreach ($categoryTerms as $key => $category) {
                                                        echo $category->name;
                                                        echo (count($categoryTerms) - 1 !== $key) ? ', ' : '';
                                                    } ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($catTerms): ?>
                                                <p class="popular-hover-card__meta-title wow fadeInUp"
                                                   data-wow-delay="1.2s">Серия:</p>
                                                <p class="popular-hover-card__meta-content wow fadeInUp"
                                                   data-wow-delay="1.2s">
                                                    <?php foreach ($catTerms
                                                                   as $key => $term):
                                                        $link = '/shop/#' . $term->slug; ?>
                                                        <a href='<?= $link ?>'><?= $term->name ?><?= array_key_last($catTerms) === $key ? '' : ', ' ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </p>
                                            <?php endif; ?>
                                            <div class="popular-hover-card__variables">
                                                <?php
                                                $variables = get_the_terms($product->get_id(), 'pa_book_type');
                                                if ($variables):
                                                    foreach ($variables as $variable) {
                                                        $variablesSlugList[$variable->slug] = '';
                                                    }
                                                    ?>
                                                    <?php foreach ($variablesSlugList as $key => $slug): ?>
                                                    <?php if ($key === 'elektronnaya-kniga'): ?>
                                                        <img data-toggle="tooltip" data-placement="bottom"
                                                             class="wow fadeInUp" data-wow-delay="1.4s"
                                                             title="Электронная книга"
                                                             src="/wp-content/themes/storefront-child/svg/svg-ebook.svg"
                                                             alt="<?= $slug ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                    <img data-toggle="tooltip" data-placement="bottom"
                                                         class="wow fadeInUp" data-wow-delay="1.5s"
                                                         title="Бумажная книга"
                                                         src="/wp-content/themes/storefront-child/svg/svg-book.svg"
                                                         alt="book">
                                                    <?php foreach ($variablesSlugList as $key => $slug): ?>
                                                    <?php if ($key === 'audiokniga'): ?>
                                                        <img data-toggle="tooltip" data-placement="bottom"
                                                             class="wow fadeInUp" data-wow-delay="1.6s"
                                                             title="Аудиокнига"
                                                             src="/wp-content/themes/storefront-child/svg/svg-audio.svg"
                                                             alt="<?= $slug ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach; ?>
                    </div>
                    <a class="carousel-control-next carouselHover-slide" href="#carouselHover" role="button"
                       data-slide="next">
                        <div>
                            <img src="/wp-content/themes/storefront-child/svg/svg-next-slide.svg" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>