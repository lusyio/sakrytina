<div class="popular-block">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <p class="popular-block__header">Популярное</p>
                <div id="popularCards" class="swiper-container popular-block-cards" data-ride="carousel">
                    <div class="swiper-wrapper">
                        <?php
                        $args = [
                            'status' => 'publish',
                            'orderby' => 'order_clause',
                            'order' => 'DESC',
                            'meta_query' => [
                                'order_clause' => [
                                    'key' => 'total_sales',
                                    'compare' => 'EXISTS',
                                ],
                            ],
                            'limit' => 4,
                        ];
                        $args['meta_query'][] = [
                            'key' => 'only_bibli',
                            'compare' => '!=',
                            'value' => '1',
                        ];
                        $query = new WC_Product_Query($args);
                        $products = $query->get_products();
                        foreach ($products as $product):
                            ?>
                        <div class="swiper-slide">
                            <div data-active="<?= $product->slug ?>" class="popular-block-card">
                                <a href="<?php echo $product->get_permalink(); ?>">
                                    <div class="popular-block-card__img">
                                        <?php echo $product->get_image('medium'); ?>
                                    </div>
                                    <p class="popular-block-card__title"><?php
                                        echo $product->get_name(); ?></p>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div id="carouselHover" data-interval="false" class="carousel carousel--popular slide carousel-fade"
                 data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    foreach ($products as $product): ?>
                        <div id="<?= $product->slug ?>" class="popular-hover-card carousel-item">
                            <div class="popular-hover-card__body">
                                <div class="popular-hover-card__img wow fadeIn" data-wow-delay="0.01s">
                                    <img src="<?= wp_get_attachment_url($product->get_image_id()); ?>"
                                         alt="">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="popular-hover-card__info">
                                        <p class="popular-hover-card__title wow fadeInUp"
                                           data-wow-delay="0.4s"><?php
                                            $title = $product->get_name();
                                            echo $title;
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

                                                if (strlen($title) > 25) {
                                                    $size = 180;
                                                }
                                                echo mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 'utf-8'), 'utf-8');
                                                echo (strlen($desc) > $size) ? '...' : '';
                                                ?></p>
                                        <?php endif; ?>
                                        <a href="<?= $product->get_permalink(); ?>"
                                           class="btn btn-primary wow fadeInUp" data-wow-delay="1s">Подробнее</a>
                                    </div>
                                    <div class="popular-hover-card__meta">
                                        <?php
                                        // награда
                                        $award = (get_post_meta($product->get_id(), 'award', true));
                                        if ($award):
                                            ?>
                                            <div class="popular-hover-card__award wow fadeInUp"
                                                 data-wow-delay="0.8s">
                                                <img src="/wp-content/themes/storefront-child/images/img-award.jpg"
                                                     alt="award">
                                                <p><?= $award; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php

                                        // жанры
                                        $tags = get_the_terms($product->get_id(), 'product_tag');
                                        foreach ($tags as $tag) {
                                            $tagNameList[] = $tag->name;
                                        }

                                        // серия
                                        $catTerms = get_the_terms($product->get_id(), 'product_cat');
                                        foreach ($catTerms as $key => $term):
                                            $catName = $term->name;
                                            $linkCat = '/shop/#' . $term->slug;
                                        endforeach;

                                        $typeName = 'Цикл';
                                        if ($catName == 'Сборник рассказов') :
                                            $typeName = 'Тип';
                                        endif;
                                        ?>
                                        <?php if ($tagNameList): ?>
                                            <p class="popular-hover-card__meta-title wow fadeInUp"
                                               data-wow-delay="1s">Жанр<?= (count($tagNameList) > 1) ? 'ы' : ''; ?>
                                                :</p>
                                            <p class="popular-hover-card__meta-content wow fadeInUp"
                                               data-wow-delay="1s">
                                                <?php foreach ($tagNameList as $key => $genre) {
                                                    echo $genre;
                                                    echo (count($tagNameList) - 1 !== $key) ? ', ' : '';
                                                }
                                                $tagNameList = array();
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($catTerms): ?>
                                            <p class="popular-hover-card__meta-title wow fadeInUp"
                                               data-wow-delay="1.2s"><?= $typeName; ?>:</p>
                                            <p class="popular-hover-card__meta-content wow fadeInUp"
                                               data-wow-delay="1.2s"><?= $catName; ?></p>
                                        <?php endif; ?>
                                        <div class="popular-hover-card__variables">
                                            <?php
                                            $variables = get_the_terms($product->get_id(), 'pa_book_type');
                                            if ($variables):
                                                foreach ($variables as $variable) {
                                                    $variablesSlugList[$variable->slug] = '';
                                                }
                                                ?>
                                                <?php
                                                foreach ($variablesSlugList as $key => $slug): ?>
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