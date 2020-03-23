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
$isVariable = false;
if ($product->is_type('variable')) {
    $isVariable = true;
    $availableVariations = $product->get_available_variations();
    $variations = [];
    foreach ($availableVariations as $availableVariation) {
        if ($availableVariation['attributes']['attribute_pa_book_type'] == 'audiokniga') {
            $variations['abook'] = $availableVariation;
        }
        if ($availableVariation['attributes']['attribute_pa_book_type'] == 'elektronnaya-kniga') {
            $variations['ebook'] = $availableVariation;
        }
    }
}

$booksArr = ['ozon_link', 'labirint_link', 'book24_link', 'chitai_gorod_link', 'bukvoed_link', 'avtograf2014_link'];
$booksAvalible = [];

// Электронная версия

// Доступна ли для продажи на сайте?

$not_to_buy = (get_post_meta($idBook, 'not_to_buy', true));

// Аудиоверсия на внешнем сайте

$externalABook = get_post_meta($idBook, 'audio_link', true);

// Бумажная версия

// Проверяем наличие бумажной версии

foreach ($booksArr as $n) :
    $link = 0;
    $link = (get_post_meta($idBook, $n, true));
    if ($link) {
        $booksAvalible[] = $link;
    }
endforeach;

    // Определяем активную вкладку
$disabledTabs = [];
if ($not_to_buy == 1) {
    $disabledTabs[] = 'ebook';
}
if (empty($booksAvalible)) {
    $disabledTabs[] = 'book';
}
if (!isset($variations['abook']) && !$externalABook) {
    $disabledTabs[] = 'abook';
}

if (!in_array('ebook', $disabledTabs)) {
    $activeTab = 'ebook';
} elseif (!in_array('book', $disabledTabs)) {
    $activeTab = 'book';
} elseif (!in_array('abook', $disabledTabs)) {
    $activeTab = 'abook';
}

$styleDBlock = 'style="display: block;"';
$styleDNone = 'style="display: none;"';

?>


<form class="variations_form cart"
      action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
      method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
      data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">

    <div class="row">
        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="elektronnaya-kniga" class="card-payment<?= ($activeTab == 'ebook') ? ' active' : '' ?><?= (in_array('ebook', $disabledTabs)) ? ' disabled' : ''; ?>">

                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="ebookTarget" id="paymentEbook" type="radio" name="variation_id" value="<?= (isset($variations['ebook'])) ? $variations['ebook']['variation_id'] : '' ?>" checked>
                    <p>Электронная книга</p>
                </div>

            </div>

        </div>

        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="" class="card-payment<?= ($activeTab == 'book') ? ' active' : '' ?><?= (in_array('book', $disabledTabs)) ? ' disabled' : ''; ?>">
                <?php if (!empty($booksAvalible)) {
                    $activateNext = false;
                }?>
                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="bookTarget" id="paymentBook" type="radio" name="variation_id">
                    <p>Бумажная книга</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12 pr-unset pr-lg-0 mb-payment">
            <div data-id="audiokniga" class="card-payment<?= ($activeTab == 'abook') ? ' active' : '' ?><?= (in_array('abook', $disabledTabs)) ? ' disabled' : ''; ?>">
                <div class="card-payment__body">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    <input data-target="audiobookTarget" id="paymentAudiobook" type="radio" name="variation_id" value="<?= (isset($variations['abook'])) ? $variations['abook']['variation_id'] : '' ?>">
                    <p>Аудиокнига</p>
                </div>
            </div>
        </div>
        <div class="col-12 pr-lg-0 pr-unset">
            <div class="card-payment-info">
                <div class="card-payment-info__body">
                    <div id="ebookTarget" class="card-payment-info__content" <?= ($activeTab == 'ebook') ? $styleDBlock : $styleDNone; ?>>
                        <div class="d-flex justify-content-between">
                            <?php do_action('woocommerce_single_variation'); ?>
                        </div>
                        <hr>
                        <p><span>Как купить?</span> Добавьте книгу в корзину и оформите заказ. Оплата осуществляется с помощью банковской карты. Книга будет отправлена вам на элекронную почту сразу же после оплаты.
                        </p>
                        <?php
                        if ($isVariable && isset($variations['ebook'])) {
                            $productVar = new WC_Product_Variation($variations['ebook']['variation_id']);
                            if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
                                $eBookDownloads = $productVar->get_downloads();
                            }
                        } elseif (!$isVariable) {
                            if ($product->is_downloadable('yes') && $product->has_file()) {
                                $eBookDownloads = $product->get_downloads();
                            }
                        }

                        if ($eBookDownloads):?>
                            <p>Книга доступна в форматах:
                                <?php foreach ($eBookDownloads as $key => $eBookDownload) {
                                    echo $eBookDownload->get_name();
                                    if ($key === array_key_last($eBookDownloads)) {
                                        echo '';
                                    } else {
                                        echo ', ';
                                    }
                                } ?></p>
                        <?php else: ?>
                            <p>Файлы не загружены</p>
                        <?php endif; ?>
                    </div>
                    <div id="bookTarget" class="card-payment-info__content" <?= ($activeTab == 'book') ? $styleDBlock : $styleDNone; ?>>
                        <p>Бумажную версию книги вы можете приобрести в любом
                            магазине-партнере.</p>
                        <div class="bookTarget__where">
                            <p>Где купить?</p>
                        </div>
                        <div class="bookTarget__links">
                            <?php

                            $id = $product->get_id();
                            $chitai_gorod_link = get_post_meta($id, 'chitai_gorod_link', true);
                            if ($chitai_gorod_link != ''): ?>
                                <a target="_blank" href="<?= $chitai_gorod_link ?>">
                                    Читай город
                                </a>
                            <?php endif;
                            $book24_link = get_post_meta($id, 'book24_link', true);
                            if ($book24_link != ''): ?>
                                <a target="_blank" href="<?= $book24_link ?>">
                                    book24
                                </a>
                            <?php endif;
                            $ozon_link = get_post_meta($id, 'ozon_link', true);
                            if ($ozon_link != ''): ?>
                                <a target="_blank" href="<?= $ozon_link ?>">
                                    Ozon
                                </a>
                            <?php endif;
                            $labirint_link = get_post_meta($id, 'labirint_link', true);
                            if ($labirint_link != ''): ?>
                                <a target="_blank" href="<?= $labirint_link ?>">
                                    Лабиринт
                                </a>
                            <?php endif;
                            $bukvoed_link = get_post_meta($id, 'bukvoed_link', true);
                            if ($bukvoed_link != ''): ?>
                                <a target="_blank" href="<?= $bukvoed_link ?>">
                                    Буквоед
                                </a>
                            <?php endif;
                            $avtograf2014_link = get_post_meta($id, 'avtograf2014_link', true);
                            if ($avtograf2014_link != ''): ?>
                                <a target="_blank" href="<?= $avtograf2014_link ?>">
                                    Автограф
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="audiobookTarget" class="card-payment-info__content" <?= ($activeTab == 'abook') ? $styleDBlock : $styleDNone; ?>>
                        <?php if (!$externalABook) : ?>
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
                            if ($isVariable && isset($variations['abook'])) {
                                $productVar = new WC_Product_Variation($variations['abook']['variation_id']);
                                if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
                                    $aBookDownloads = $productVar->get_downloads();
                                }
                            }
                            if ($aBookDownloads):?>
                                <p>Книга доступна в форматах:
                                    <?php foreach ($aBookDownloads as $key => $aBookDownload) {
                                        echo $aBookDownload->get_name();
                                        if ($key === array_key_last($aBookDownloads)) {
                                            echo '';
                                        } else {
                                            echo ', ';
                                        }
                                    } ?></p>
                            <?php else: ?>
                                <p>Файлы не загружены</p>
                            <?php endif; ?>

                        <?php else : ?>
                            <div class="audioTarget">
                                <p>Аудио версию книги вы можете приобрести в
                                    магазине-партнере.</p>
                                <div class="bookTarget__where">
                                    <p><a href="<?= $externalABook; ?>" target="_blank">Купить аудио версию</a></p>
                                </div>

                            </div>

                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</form>