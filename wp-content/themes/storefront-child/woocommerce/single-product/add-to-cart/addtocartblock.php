<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */


$idBook = $product->get_id();

// определяем доступные табы

// Электронная версия

// Доступна ли для продажи на сайте?

$not_to_buy = (get_post_meta($idBook, 'not_to_buy', true));





?>


<form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
      method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
      data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">

    <div class="row">
        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="elektronnaya-kniga"
                 class="card-payment">
                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="ebookTarget" id="paymentEbook" type="radio" name="payment" checked>
                    <p>Электронная книга</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="" class="card-payment">
                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="bookTarget" id="paymentBook" type="radio" name="payment">
                    <p>Бумажная книга</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="audiokniga"
                 class="card-payment">
                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="audiobookTarget" id="paymentAudiobook" type="radio" name="payment">
                    <p>Аудиокнига</p>
                </div>
            </div>
        </div>
        <div class="col-12 pr-lg-0 pr-unset">
            <div class="card-payment-info">
                <div class="card-payment-info__body">
                    <div id="ebookTarget" class="card-payment-info__content">
                        <div class="d-flex justify-content-between">
                            <?php do_action('woocommerce_single_variation'); ?>
                        </div>
                        <hr>
                        <p><span>Как купить?</span> Добавьте книгу в корзину и оформите заказ. Оплата осуществляется
                            с
                            помощью
                            банковской
                            карты. Книга будет отправлена вам на элекронную почту сразу же после оплаты.
                        </p>
                        <?php
                        $audioId = array_search('elektronnaya-kniga', $arr);
                        $productVar = new WC_Product_Variation($audioId);
                        if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
                            $item_downloads = $productVar->get_downloads();
                        }
                        if ($item_downloads):?>
                            <p>Книга доступна в форматах:
                                <?php foreach ($item_downloads as $key => $item_download) {
                                    echo $item_download->get_name();
                                    if ($key === array_key_last($item_downloads)) {
                                        echo '';
                                    } else {
                                        echo ', ';
                                    }
                                } ?></p>
                        <?php else: ?>
                            <p>Файлы не загружены</p>
                        <?php endif; ?>
                    </div>
                    <div id="bookTarget" class="card-payment-info__content">
                        <p>Бумажную версию книги вы можете приобрести в любом
                            магазине-партнере.</p>
                        <div class="bookTarget__where">
                            <p>Где купить?</p>
                        </div>
                        <div class="bookTarget__links">
                            <?php
                            $id = $product->get_id();
                            $chitai_gorod_link = get_post_meta($id, 'chitai_gorod_link');
                            if (!!$chitai_gorod_link): ?>
                                <a target="_blank" href="<?= $chitai_gorod_link[0] ?>">
                                    Читай город
                                </a>
                            <?php endif;
                            $book24_link = get_post_meta($id, 'book24_link');
                            if (!!$book24_link): ?>
                                <a target="_blank" href="<?= $book24_link[0] ?>">
                                    book24
                                </a>
                            <?php endif;
                            $ozon_link = get_post_meta($id, 'ozon_link');
                            if (!!$ozon_link): ?>
                                <a target="_blank" href="<?= $ozon_link[0] ?>">
                                    Ozon
                                </a>
                            <?php endif;
                            $labirint_link = get_post_meta($id, 'labirint_link');
                            if (!!$labirint_link): ?>
                                <a target="_blank" href="<?= $labirint_link[0] ?>">
                                    Лабиринт
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="audiobookTarget"
                         class="card-payment-info__content">
                        <?php if(empty($audio_link)) :?>
                            <div class="d-flex justify-content-between">
                                <?php do_action('woocommerce_single_variation'); ?>
                            </div>
                            <hr>



                            <p><span>Как купить?</span> Добавьте книгу в корзину и оформите заказ. Оплата осуществляется
                                с
                                помощью
                                банковской
                                карты. Книга будет отправлена вам на элекронную почту сразу же после оплаты.
                            </p>

                            <?php
                            $audioId = array_search('audiokniga', $arr);
                            $productVar = new WC_Product_Variation($audioId);
                            if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
                                $item_downloads = $productVar->get_downloads();
                            }
                            if ($item_downloads):?>
                                <p>Книга доступна в форматах:
                                    <?php foreach ($item_downloads as $key => $item_download) {
                                        echo $item_download->get_name();
                                        if ($key === array_key_last($item_downloads)) {
                                            echo '';
                                        } else {
                                            echo ', ';
                                        }
                                    } ?></p>
                            <?php else: ?>
                                <p>Файлы не загружены</p>
                            <?php endif; ?>

                        <?php else :?>
                            <div class="audioTarget">
                                <p>Аудио версию книги вы можете приобрести в
                                    магазине-партнере.</p>
                                <div class="bookTarget__where">
                                    <p><a href="<?=$audio_link;?>" target="_blank">Купить аудио версию</a></p>
                                </div>

                            </div>

                        <?php endif;?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</form>