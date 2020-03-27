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

$litnetLink = get_post_meta($idBook, 'read_fragment_link', true);
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
} else {
    $activeTab = 'litnet';
}

$styleDBlock = 'style="display: block;"';
$styleDNone = 'style="display: none;"';


if ($isVariable && isset($variations['ebook'])) {
    $productVar = new WC_Product_Variation($variations['ebook']['variation_id']);
    if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
        $eBookDownloads = $productVar->get_downloads();
        $eBookPriceHtml = $productVar->get_price_html();
    }
} elseif (!$isVariable) {
    if ($product->is_downloadable('yes') && $product->has_file()) {
        $eBookDownloads = $product->get_downloads();
        $eBookPriceHtml = $product->get_price_html();
    }
}

if ($isVariable && isset($variations['abook'])) {
    $productVar = new WC_Product_Variation($variations['abook']['variation_id']);
    if ($productVar->is_downloadable('yes') && $productVar->has_file()) {
        $aBookDownloads = $productVar->get_downloads();
        $aBookPriceHtml = $productVar->get_price_html();
    }
}

?>


<form class="variations_form cart"
      action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
      method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
      data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">

    <div class="row">
        <div class="col-lg-4 col-md-4 col-12 pr-unset pr-lg-0 mb-payment <?= (in_array('ebook', $disabledTabs)) ? 'd-md-block d-none' : ''; ?>">
            <div data-id="elektronnaya-kniga"
                 class="card-payment<?= ($activeTab == 'ebook') ? ' active' : '' ?><?= (in_array('ebook', $disabledTabs)) ? ' disabled' : ''; ?>">

                <div class="card-payment__body">
                    <div>
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M36.8188 0H11.2189C9.01062 0.00256348 7.22131 1.79187 7.21875 4.00012V43.9999C7.22131 46.2081 9.01062 47.9974 11.2189 48H36.8188C39.0267 47.9974 40.816 46.2081 40.8186 43.9999V4.00012C40.816 1.79187 39.0267 0.00256348 36.8188 0V0ZM39.2186 43.9999C39.2186 45.3256 38.1442 46.4 36.8188 46.4H11.2189C9.89319 46.4 8.81873 45.3256 8.81873 43.9999V4.00012C8.81873 2.67444 9.89319 1.59998 11.2189 1.59998H36.8188C38.1442 1.59998 39.2186 2.67444 39.2186 4.00012V43.9999Z"
                                      fill="#626262"></path>
                                <path d="M36.0189 3.19995H12.0189C11.1353 3.19995 10.4189 3.91626 10.4189 4.79993V40.0001C10.4189 40.8838 11.1353 41.6001 12.0189 41.6001H36.0189C36.9026 41.6001 37.6189 40.8838 37.6189 40.0001V4.79993C37.6189 3.91626 36.9026 3.19995 36.0189 3.19995ZM12.0189 40.0001V4.79993H36.0189V40.0001H12.0189Z"
                                      fill="#626262"></path>
                                <path d="M24.8191 43.2H23.2191C22.7771 43.2 22.4189 43.5581 22.4189 43.9998C22.4189 44.4418 22.7771 44.7999 23.2191 44.7999H24.8191C25.2607 44.7999 25.6189 44.4418 25.6189 43.9998C25.6189 43.5581 25.2607 43.2 24.8191 43.2Z"
                                      fill="#626262"></path>
                                <path d="M14.4188 9.59998H17.6188C18.0604 9.59998 18.4186 9.24182 18.4186 8.80017C18.4186 8.35815 18.0604 8 17.6188 8H14.4188C13.9768 8 13.6187 8.35815 13.6187 8.80017C13.6187 9.24182 13.9768 9.59998 14.4188 9.59998Z"
                                      fill="#626262"></path>
                                <path d="M33.6189 8H20.8187C20.3767 8 20.0186 8.35815 20.0186 8.80017C20.0186 9.24182 20.3767 9.60034 20.8187 9.60034H33.6189C34.0605 9.60034 34.4187 9.24182 34.4187 8.80017C34.4187 8.35815 34.0605 8 33.6189 8Z"
                                      fill="#626262"></path>
                                <path d="M33.6189 12.8003H14.4188C13.9768 12.8003 13.6187 13.1584 13.6187 13.6001C13.6187 14.0421 13.9768 14.4003 14.4188 14.4003H33.6189C34.0605 14.4003 34.4187 14.0421 34.4187 13.6001C34.4187 13.1584 34.0605 12.8003 33.6189 12.8003Z"
                                      fill="#626262"></path>
                                <path d="M33.6189 17.6001H14.4188C13.9768 17.6001 13.6187 17.9583 13.6187 18.3999C13.6187 18.8419 13.9768 19.2001 14.4188 19.2001H33.6189C34.0605 19.2001 34.4187 18.8419 34.4187 18.3999C34.4187 17.9583 34.0605 17.6001 33.6189 17.6001Z"
                                      fill="#626262"></path>
                                <path d="M14.4188 23.9999H28.8186C29.2606 23.9999 29.6188 23.6417 29.6188 23.2001C29.6188 22.7581 29.2606 22.3999 28.8186 22.3999H14.4188C13.9768 22.3999 13.6187 22.7581 13.6187 23.2001C13.6187 23.6417 13.9768 23.9999 14.4188 23.9999Z"
                                      fill="#626262"></path>
                                <path d="M33.6189 22.3999H32.0186C31.5769 22.3999 31.2188 22.7581 31.2188 23.2001C31.2188 23.6417 31.5769 23.9999 32.0186 23.9999H33.6189C34.0605 23.9999 34.4187 23.6417 34.4187 23.2001C34.4187 22.7581 34.0605 22.3999 33.6189 22.3999Z"
                                      fill="#626262"></path>
                                <path d="M33.6189 27.2H14.4188C13.9768 27.2 13.6187 27.5581 13.6187 28.0001C13.6187 28.4418 13.9768 28.7999 14.4188 28.7999H33.6189C34.0605 28.7999 34.4187 28.4418 34.4187 28.0001C34.4187 27.5581 34.0605 27.2 33.6189 27.2Z"
                                      fill="#626262"></path>
                                <path d="M16.0188 32H14.4188C13.9768 32 13.6187 32.3582 13.6187 32.8002C13.6187 33.2418 13.9768 33.6 14.4188 33.6H16.0188C16.4604 33.6 16.819 33.2418 16.819 32.8002C16.819 32.3582 16.4604 32 16.0188 32Z"
                                      fill="#626262"></path>
                                <path d="M33.6188 32H19.2186C18.777 32 18.4185 32.3582 18.4185 32.8002C18.4185 33.2418 18.777 33.6 19.2186 33.6H33.6188C34.0604 33.6 34.4186 33.2418 34.4186 32.8002C34.4186 32.3582 34.0604 32 33.6188 32Z"
                                      fill="#626262"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="48" height="48" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                        <input data-target="ebookTarget" id="paymentEbook" type="radio" name="variation_id"
                               value="<?= (isset($variations['ebook'])) ? $variations['ebook']['variation_id'] : '' ?>"
                               checked>
                        <p>Электронная книга</p>
                    </div>
                    <p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php echo $eBookPriceHtml ?></p>
                </div>

            </div>

        </div>

        <div class="col-lg-4 col-md-4 col-12 pr-unset pr-lg-0 mb-payment <?= (in_array('book', $disabledTabs)) ? 'd-md-block d-none' : ''; ?>">
            <div data-id=""
                 class="card-payment<?= ($activeTab == 'book') ? ' active' : '' ?><?= (in_array('book', $disabledTabs)) ? ' disabled' : ''; ?>">
                <?php if (!empty($booksAvalible)) {
                    $activateNext = false;
                } ?>
                <div class="card-payment__body">
                    <div>
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M41.6001 0H9.6001C7.3921 0.0026 5.6027 1.792 5.6001 4V44C5.6027 46.208 7.3921 47.9974 9.6001 48H41.6001C42.0419 48 42.4001 47.6418 42.4001 47.2V0.8C42.4001 0.3582 42.0419 0 41.6001 0ZM32.0001 1.6H36.8001V9.1056L34.7577 8.084C34.5326 7.9715 34.2676 7.9715 34.0425 8.084L32.0001 9.1056V1.6ZM7.2001 4C7.2001 2.6745 8.2746 1.6 9.6001 1.6H10.4001V38.4H9.6001C8.7317 38.4029 7.8884 38.6914 7.2001 39.2208V4ZM40.8001 42.4H10.4001V44H40.8001V46.4H9.6001C8.2746 46.4 7.2001 45.3255 7.2001 44V42.4C7.2001 41.0745 8.2746 40 9.6001 40H40.8001V42.4ZM40.8001 38.4H12.0001V1.6H30.4001V10.4C30.3999 10.8418 30.7579 11.2002 31.1997 11.2004C31.324 11.2005 31.4465 11.1716 31.5577 11.116L34.4001 9.6944L37.2425 11.12C37.6377 11.3175 38.1182 11.1572 38.3157 10.762C38.3719 10.6496 38.4008 10.5256 38.4001 10.4V1.6H40.8001V38.4Z"
                                  fill="#626262"></path>
                        </svg>
                        <input data-target="bookTarget" id="paymentBook" type="radio" name="variation_id">
                        <p>Бумажная книга</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12 pr-unset pr-lg-0 mb-payment <?= (in_array('abook', $disabledTabs)) ? 'd-md-block d-none' : ''; ?>">
            <div data-id="audiokniga"
                 class="card-payment<?= ($activeTab == 'abook') ? ' active' : '' ?><?= (in_array('abook', $disabledTabs)) ? ' disabled' : ''; ?>">
                <div class="card-payment__body">
                    <div>
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M46.2186 24.0001C46.2233 20.7283 45.5033 17.4962 44.1104 14.5358C42.7174 11.5754 40.686 8.96027 38.1621 6.87835C34.1779 3.58403 29.1699 1.78174 24.0002 1.78174C18.8305 1.78174 13.8225 3.58403 9.83833 6.87835C6.27192 9.82706 3.7157 13.8162 2.52677 18.2884C1.33784 22.7606 1.5756 27.4925 3.20683 31.823C2.48111 32.6059 2.0073 33.5887 1.84683 34.6441C1.68636 35.6995 1.84661 36.7787 2.30683 37.742L4.92358 43.1971C5.22504 43.828 5.64804 44.3932 6.16834 44.8603C6.68864 45.3275 7.29601 45.6873 7.95564 45.9193C8.61527 46.1513 9.31419 46.2508 10.0124 46.2122C10.7105 46.1736 11.3942 45.9975 12.0242 45.6942L12.5777 45.4287C12.6251 45.4053 12.6694 45.3763 12.7097 45.3421C13.1938 45.5012 13.7139 45.5144 14.2054 45.3801C14.6969 45.2457 15.1381 44.9697 15.4739 44.5865C15.8097 44.2032 16.0253 43.7297 16.0939 43.2248C16.1625 42.7198 16.0811 42.2059 15.8597 41.747L9.87058 29.2737C9.70039 28.9167 9.45083 28.6033 9.14096 28.3575C8.8311 28.1118 8.46914 27.9401 8.08276 27.8556C7.69638 27.7712 7.2958 27.7762 6.91165 27.8703C6.5275 27.9644 6.16995 28.145 5.86633 28.3985C5.05697 25.0534 5.18952 21.5495 6.24927 18.2752C7.30903 15.0008 9.25461 12.0837 11.8705 9.84722C12.1384 9.9882 12.4362 10.0633 12.739 10.0662C13.1446 10.0654 13.5399 9.93784 13.8696 9.70135C16.8291 7.59859 20.3696 6.46886 24 6.46886C27.6305 6.46886 31.171 7.59859 34.1305 9.70135C34.418 9.90855 34.7572 10.0322 35.1105 10.0587C35.4639 10.0852 35.8178 10.0134 36.1329 9.85135C38.7475 12.088 40.6919 15.0047 41.7509 18.2784C42.8099 21.5521 42.9422 25.055 42.1329 28.3992C41.8293 28.1458 41.4718 27.9651 41.0876 27.871C40.7035 27.7769 40.3029 27.7719 39.9165 27.8564C39.5301 27.9408 39.1682 28.1125 38.8583 28.3583C38.5485 28.6041 38.2989 28.9175 38.1287 29.2745L32.1411 41.747C31.9171 42.2058 31.8337 42.7207 31.9013 43.2268C31.9688 43.7329 32.1844 44.2078 32.5209 44.5919C32.8573 44.9759 33.2997 45.252 33.7926 45.3856C34.2854 45.5191 34.8067 45.5041 35.2911 45.3425C35.3315 45.3764 35.3758 45.4053 35.4231 45.4287L35.9766 45.6946C37.2494 46.3049 38.7125 46.3847 40.0441 45.9163C41.3757 45.4479 42.4667 44.4698 43.0772 43.1971L45.694 37.742C46.1542 36.7787 46.3144 35.6995 46.1539 34.6441C45.9935 33.5887 45.5197 32.6059 44.7939 31.823C45.7399 29.3235 46.2226 26.6726 46.2186 24.0001ZM8.39045 44.6783C7.89309 44.5049 7.43506 44.2345 7.04287 43.8828C6.65068 43.5312 6.3321 43.1053 6.10558 42.6297L3.4892 37.1742C3.0333 36.2219 2.97112 35.1283 3.31614 34.1304C3.66116 33.1326 4.38557 32.3109 5.33233 31.8436L11.4167 44.5291C10.467 44.9756 9.37947 45.0292 8.39045 44.6783ZM6.96545 29.2377C7.13877 29.154 7.32874 29.1106 7.5212 29.1106C7.76444 29.1105 8.00277 29.1791 8.20875 29.3085C8.41474 29.4378 8.58002 29.6227 8.68558 29.8418L14.6755 42.3151C14.7487 42.4678 14.7912 42.6334 14.8004 42.8024C14.8097 42.9715 14.7855 43.1407 14.7294 43.3005C14.6732 43.4602 14.5862 43.6074 14.4732 43.7335C14.3602 43.8596 14.2234 43.9622 14.0708 44.0354C13.9181 44.1087 13.7525 44.1511 13.5834 44.1604C13.4144 44.1696 13.2451 44.1455 13.0854 44.0894C12.9256 44.0332 12.7785 43.9461 12.6524 43.8331C12.5263 43.7201 12.4237 43.5834 12.3505 43.4307L6.37483 30.9807L6.36395 30.9575C6.2906 30.8049 6.24803 30.6394 6.23869 30.4703C6.22936 30.3013 6.25343 30.1321 6.30954 29.9724C6.36565 29.8127 6.45269 29.6656 6.56569 29.5395C6.67868 29.4134 6.81542 29.3109 6.96808 29.2377H6.96545ZM4.03108 24.0001C4.03014 26.0377 4.34138 28.0635 4.95395 30.0068C4.92463 30.1966 4.91658 30.389 4.92995 30.5806L4.80283 30.6413C4.6217 30.7291 4.44567 30.827 4.27558 30.9346C2.89228 26.9983 2.71888 22.738 3.7777 18.7022C4.83652 14.6665 7.0791 11.0401 10.2167 8.28985L10.8748 8.97385C8.72446 10.8422 7.00057 13.1507 5.81984 15.7432C4.63911 18.3356 4.02909 21.1514 4.03108 24.0001ZM34.8913 8.63222C31.7096 6.37117 27.9031 5.15639 23.9998 5.15639C20.0965 5.15639 16.29 6.37117 13.1083 8.63222C12.9881 8.72025 12.8401 8.76182 12.6917 8.74928C12.5432 8.73674 12.4043 8.67092 12.3006 8.56397L11.2273 7.44722C14.8869 4.62468 19.3783 3.09382 23.9998 3.09382C28.6214 3.09382 33.1128 4.62468 36.7723 7.44722L35.6998 8.5636C35.5961 8.6708 35.4571 8.73681 35.3084 8.74943C35.1598 8.76204 35.0116 8.72041 34.8913 8.63222ZM37.1248 8.97385L37.7822 8.28985C40.9201 11.0399 43.1629 14.6662 44.222 18.702C45.2811 22.7377 45.108 26.9981 43.7248 30.9346C43.5547 30.827 43.3787 30.7291 43.1976 30.6413L43.0704 30.5802C43.0838 30.3888 43.0758 30.1965 43.0465 30.0068C44.2133 26.3051 44.2746 22.3432 43.2227 18.6071C42.1709 14.871 40.0516 11.5231 37.1248 8.97385ZM33.9276 44.0363C33.6197 43.8881 33.3832 43.6238 33.2699 43.3014C33.1567 42.979 33.1759 42.6248 33.3235 42.3166L39.3115 29.8433C39.417 29.6242 39.5823 29.4393 39.7883 29.31C39.9943 29.1806 40.2326 29.112 40.4758 29.1121C40.6936 29.1124 40.9078 29.1679 41.0983 29.2735C41.2888 29.379 41.4495 29.5311 41.5654 29.7155C41.6812 29.8999 41.7484 30.1107 41.7607 30.3282C41.773 30.5456 41.73 30.7626 41.6357 30.959L41.6248 30.9822L35.6477 43.4322C35.5745 43.5849 35.4719 43.7216 35.3458 43.8346C35.2197 43.9476 35.0726 44.0347 34.9128 44.0908C34.7531 44.1469 34.5839 44.171 34.4148 44.1616C34.2457 44.1523 34.0802 44.1097 33.9276 44.0363ZM44.5097 37.1738L41.8933 42.6293C41.4367 43.5817 40.6227 44.3154 39.6283 44.671C38.6338 45.0267 37.5392 44.9755 36.5822 44.5287L42.6673 31.8436C43.6144 32.3106 44.3392 33.1321 44.6846 34.13C45.03 35.1279 44.9681 36.2217 44.5123 37.1742L44.5097 37.1738Z"
                                  fill="#626262"></path>
                        </svg>
                        <input data-target="audiobookTarget" id="paymentAudiobook" type="radio" name="variation_id"
                               value="<?= (isset($variations['abook'])) ? $variations['abook']['variation_id'] : '' ?>">
                        <p>Аудиокнига</p>
                    </div>
                    <p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php
                        if (!$externalABook && isset($variations['abook'])) {
                            echo $aBookPriceHtml;
                        }
                        ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 pr-lg-0 pr-unset">
            <div class="card-payment-info">
                <div class="card-payment-info__body">
                    <div id="ebookTarget" class="card-payment-info__content"
                         <?= ($activeTab == 'ebook') ? $styleDBlock : $styleDNone; ?>>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php echo $eBookPriceHtml ?></p>
                            </div>
                            <?php do_action('woocommerce_single_variation'); ?>
                        </div>
                        <hr>
                        <p><span>Как купить?</span> Добавьте книгу в корзину и оформите заказ. Оплата осуществляется с
                            помощью банковской карты. Книга будет отправлена вам на элекронную почту сразу же после
                            оплаты.
                        </p>
                        <?php if ($eBookDownloads): ?>
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
                    <div id="bookTarget" class="card-payment-info__content"
                         <?= ($activeTab == 'book') ? $styleDBlock : $styleDNone; ?>>
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
                    <div id="audiobookTarget" class="card-payment-info__content"
                         <?= ($activeTab == 'abook') ? $styleDBlock : $styleDNone; ?>>
                        <?php if (!$externalABook) : ?>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php echo $aBookPriceHtml ?></p>
                                </div>
                                <?php do_action('woocommerce_single_variation'); ?>
                            </div>
                            <hr>


                            <p><span>Как купить?</span> Добавьте книгу в корзину и оформите заказ. Оплата осуществляется
                                с
                                помощью
                                банковской
                                карты. Книга будет отправлена вам на элекронную почту сразу же после оплаты.
                            </p>


                            <?php if ($aBookDownloads): ?>
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
                    <div id="litnetTarget" class="book-target card-payment-info__content"
                         <?= ($activeTab == 'litnet' && $litnetLink != '') ? $styleDBlock : $styleDNone; ?>>
                        <p>Данную книгу можно приобрести только на сайте Литнет</p>
                        <div class="bookTarget__where">
                            <p></p>
                        </div>
                        <div class="bookTarget__links">
                            <a target="_blank" href="<?= $litnetLink ?>">
                                Перейти на Литнет
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>