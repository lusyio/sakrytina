<?php
/**
 * Richbee functions and definitions
 *
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );
/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style()
{
    wp_dequeue_style('storefront-style');
    wp_dequeue_style('storefront-woocommerce-style');
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */
function enqueue_child_theme_styles()
{
// load bootstrap css
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/inc/assets/css/bootstrap.min.css', false, NULL, 'all');
// fontawesome cdn
    wp_enqueue_style('wp-bootstrap-pro-fontawesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css');
// load bootstrap css
// load AItheme styles
// load WP Bootstrap Starter styles
    wp_enqueue_style('wp-bootstrap-starter-style', get_stylesheet_uri(), array('theme'));
    if (get_theme_mod('theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
        wp_enqueue_style('wp-bootstrap-starter-' . get_theme_mod('theme_option_setting'), get_template_directory_uri() . '/inc/assets/css/presets/theme-option/' . get_theme_mod('theme_option_setting') . '.css', false, '');
    }
    wp_enqueue_style('wp-bootstrap-starter-robotoslab-roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap');

    wp_enqueue_script('jquery');

    // Internet Explorer HTML5 support
    wp_enqueue_script('html5hiv', get_template_directory_uri() . '/inc/assets/js/html5.js', array(), '3.7.0', false);
    wp_script_add_data('html5hiv', 'conditional', 'lt IE 9');

// load swiper js and css
    wp_enqueue_script('wp-swiper-js', get_stylesheet_directory_uri() . '/inc/assets/js/swiper.min.js', array(), '', true);
    wp_enqueue_style('wp-swiper-js', get_stylesheet_directory_uri() . '/inc/assets/css/swiper.min.css', array(), '');

// load bootstrap js
    wp_enqueue_script('wp-bootstrap-starter-popper', get_stylesheet_directory_uri() . '/inc/assets/js/popper.min.js', array(), '', true);
    wp_enqueue_script('wp-bootstrap-starter-bootstrapjs', get_stylesheet_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true);
    wp_enqueue_script('wp-bootstrap-starter-themejs', get_stylesheet_directory_uri() . '/inc/assets/js/theme-script.min.js', array(), '', true);
    wp_enqueue_script('wp-bootstrap-starter-skip-link-focus-fix', get_stylesheet_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
//enqueue my child theme stylesheet
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('theme'));
}

add_action('wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);

remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress

$my_js_ver = date("ymd-Gis", filemtime(plugin_dir_path(__FILE__) . 'inc/assets/js/custom.js'));

wp_enqueue_script('custom', '/wp-content/themes/storefront-child/inc/assets/js/custom.js', array('jquery'), $my_js_ver, true);

/**
 * Load custom WordPress nav walker.
 */
if (!class_exists('wp_bootstrap_navwalker')) {
    require_once(get_stylesheet_directory() . '/inc/wp_bootstrap_navwalker.php');
}

/**
 * Удаление json-api ссылок
 */
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11);

/**
 * Cкрываем разные линки при отображении постов блога (следующий, предыдущий, короткий url)
 */
remove_action('wp_head', 'start_post_rel_link', 10);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

/**
 * `Disable Emojis` Plugin Version: 1.7.2
 */
if ('Отключаем Emojis в WordPress') {

    /**
     * Disable the emoji's
     */
    function disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
    }

    add_action('init', 'disable_emojis');

    /**
     * Filter function used to remove the tinymce emoji plugin.
     *
     * @param array $plugins
     * @return   array             Difference betwen the two arrays
     */
    function disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        }

        return array();
    }

    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param array $urls URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed for.
     * @return array                 Difference betwen the two arrays.
     */
    function disable_emojis_remove_dns_prefetch($urls, $relation_type)
    {

        if ('dns-prefetch' == $relation_type) {

            // Strip out any URLs referencing the WordPress.org emoji location
            $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
            foreach ($urls as $key => $url) {
                if (strpos($url, $emoji_svg_url_bit) !== false) {
                    unset($urls[$key]);
                }
            }

        }

        return $urls;
    }

}

/**
 * Удаляем стили для recentcomments из header'а
 */
function remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

add_action('widgets_init', 'remove_recent_comments_style');

/**
 * Удаляем ссылку на xmlrpc.php из header'а
 */
remove_action('wp_head', 'wp_bootstrap_starter_pingback_header');

/**
 * Удаляем стили для #page-sub-header из  header'а
 */
remove_action('wp_head', 'wp_bootstrap_starter_customizer_css');

/*
*Обновление количества товара
*/
add_filter('woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment');

function header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    ob_start();
    ?>
    <span id="basket-btn__counter"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></span>
    <?php
    $fragments['basket'] = ob_get_clean();
    return $fragments;
}

/*
*Обновление количества товара
*/
add_filter('woocommerce_add_to_cart_fragments', 'card_payment_info');

function card_payment_info($fragments)
{
    global $product;
    ob_start();

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>

            <button data-href="<?= wc_get_cart_remove_url($cart_item_key) ?>"
                    data-product_id="" data-product_sku=""
                    type="submit" class="btn btn-primary remove-book">Удалить из корзины
            </button>

            <?php break; endforeach;
    ?>

    <?php
    $fragments['paymentInfo'] = ob_get_clean();
    return $fragments;
}

/**
 * Замена надписи на кнопке Добавить в корзину
 */
add_filter('woocommerce_product_single_add_to_cart_text', 'woocust_change_label_button_add_to_cart_single');
function woocust_change_label_button_add_to_cart_single($label)
{

    $label = 'Добавить в корзину';

    return $label;
}

/**
 * Удаляем поля адрес и телефон, если нет доставки
 */

add_filter('woocommerce_checkout_fields', 'new_woocommerce_checkout_fields', 10, 1);

function new_woocommerce_checkout_fields($fields)
{
    if (!WC()->cart->needs_shipping()) {
        unset($fields['billing']['billing_address_1']); //удаляем Населённый пункт
        unset($fields['billing']['billing_address_2']); //удаляем Населённый пункт
        unset($fields['billing']['billing_city']); //удаляем Населённый пункт
        unset($fields['billing']['billing_postcode']); //удаляем Населённый пункт
        unset($fields['billing']['billing_country']); //удаляем Населённый пункт
        unset($fields['billing']['billing_state']); //удаляем Населённый пункт
        unset($fields['billing']['billing_company']); //удаляем Населённый пункт
        unset($fields['billing']['phone']); //удаляем Населённый пункт
        unset($fields['order']['order_comments']);
        unset($fields['billing']['billing_last_name']);
        unset($fields['billing']['billing_phone']);

    }
    return $fields;
}

remove_action('storefront_footer', 'storefront_credit', 20);

/**
 * Remove product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

function woo_remove_product_tabs($tabs)
{

    unset($tabs['description']);        // Remove the description tab
    unset($tabs['reviews']);            // Remove the reviews tab
    unset($tabs['additional_information']);    // Remove the additional information tab

    return $tabs;
}

//Количество товаров для вывода на странице магазина
add_filter('loop_shop_per_page', 'wg_view_all_products');

function wg_view_all_products()
{
    return '9999';
}

//Удаление сортировки
add_action('init', 'bbloomer_delay_remove');

function bbloomer_delay_remove()
{
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);

}

/*
*Изменение количетсва товара на строку на страницах woo
*/
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 3; // 3 products per row
    }
}


//Удаление сторфронт-кредит
add_action('init', 'custom_remove_footer_credit', 10);

function custom_remove_footer_credit()
{
    remove_action('storefront_footer', 'storefront_credit', 20);
    //    add_action('storefront_footer', 'custom_storefront_credit', 20);
}


//Добавление favicon
function favicon_link()
{
    echo '
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png"/>' . "\n";
}

add_action('wp_head', 'favicon_link');

//Изменение entry-content
function storefront_page_content()
{
    ?>
    <div class="row">
        <?php the_content(); ?>
        <?php
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __('Pages:', 'storefront'),
                'after' => '</div>',
            )
        );
        ?>
    </div>
    <?php
}

add_filter('woocommerce_sale_flash', 'my_custom_sale_flash', 10, 3);
function my_custom_sale_flash($text, $post, $_product)
{
    return '<span class="onsale">SALE!</span>';
}

// Колонки related
add_filter('woocommerce_output_related_products_args', 'jk_related_products_args');
function jk_related_products_args($args)
{
    $args['posts_per_page'] = 6; // количество "Похожих товаров"
    $args['columns'] = 4; // количество колонок
    return $args;
}

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

//change category title templete for carousel controls
remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
add_action('woocommerce_shop_loop_subcategory_title', 'custom_woocommerce_template_loop_category_title', 10);
function custom_woocommerce_template_loop_category_title($category)
{
    ?>
    <h2 id="<?= $category->slug ?>" class="woocommerce-loop-category__title">
        <?php
        echo $category->name;
        if ($category->count > 3) :?>
            <div class="carousel-books-control">
                <span class="carousel-books-control-prev <?= $category->slug ?>"><svg width="31" height="16"
                                                                                      viewBox="0 0 31 16" fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.292891 8.70711C-0.097633 8.31658 -0.097633 7.68342 0.292891 7.29289L6.65685 0.928932C7.04738 0.538408 7.68054 0.538408 8.07107 0.928932C8.46159 1.31946 8.46159 1.95262 8.07107 2.34315L2.41421 8L8.07107 13.6569C8.46159 14.0474 8.46159 14.6805 8.07107 15.0711C7.68054 15.4616 7.04738 15.4616 6.65685 15.0711L0.292891 8.70711ZM31 9H0.999998V7H31V9Z"
                              fill="#B9B9B9"/>
                    </svg></span><span class="carousel-books-control-next <?= $category->slug ?>"><svg width="31"
                                                                                                       height="16"
                                                                                                       viewBox="0 0 31 16"
                                                                                                       fill="none"
                                                                                                       xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z"
                              fill="#B9B9B9"/>
                    </svg></span>
            </div>
        <?php endif; ?>
    </h2>
    <?php
}

// remove page title on shop page
add_filter('woocommerce_show_page_title', 'not_a_shop_page');
function not_a_shop_page()
{
    return boolval(!is_shop());
}

/**
 * Change the breadcrumb
 */
add_filter('woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs', 20);
function jk_woocommerce_breadcrumbs()
{
    return array(
        'delimiter' => ' / ',
        'wrap_before' => '<div class="storefront-breadcrumb"><div class="container"><div class="row"><div class="col-12"><nav class="woocommerce-breadcrumb">',
        'wrap_after' => '</nav></div></div></div></div>',
        'home' => _x('Home', 'breadcrumb', 'woocommerce'),
    );
}

/**
 * Remove related products output
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/* Remove product meta */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

/**
 * @desc Remove in all product type
 */
function wc_remove_all_quantity_fields($return, $product)
{
    return true;
}

add_filter('woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

/**
 * Remove breadcrumbs on specific pages
 */
add_action('remove_breadcrumbs', 'wcc_remove_woo_wc_breadcrumbs');
function wcc_remove_woo_wc_breadcrumbs()
{
    if (is_product()) {
        remove_action('woo_main_before', 'woo_display_breadcrumbs', 10);
    }
}

/**
 * Handle a custom 'customvar' query var to get products with the 'customvar' meta.
 * @param array $query - Args for WP_Query.
 * @param array $query_vars - Query vars from WC_Product_Query.
 * @return array modified $query
 */
function handle_custom_query_var($query, $query_vars)
{
    if (!empty($query_vars['pa_year_publication'])) {
        $query['meta_query'][] = array(
            'posts_per_page' => -1,
            'key' => 'pa_year_publication',
            'value' => esc_attr($query_vars['pa_year_publication']),
        );
        var_dump($query);
    }

    return $query;
}

add_filter('woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2);

add_filter('woocommerce_sale_flash', 'lw_hide_sale_flash');
function lw_hide_sale_flash()
{
    return false;
}

function mytheme_comment($comment, $args, $depth)
{
    global $product;
    $GLOBALS['comment'] = $comment;
    $args = array(
        'post_id' => $product->get_id()
    );
    $comments = get_comments($args);
    $first_comment_id = $comments[0]->comment_ID;
    ?>
    <div class="post <?= $first_comment_id === $comment->comment_ID ? 'active' : '' ?> carousel-item">
        <p class="comment__title"><?= $comment->comment_author ?><?= get_comment_date($d = ', F jS Y', $comment) ?> <?= preg_replace('#^https?://#', '', $comment->comment_author_url); ?></p>
        <div class="comment__content">
            <p><?php
                $desc = $comment->comment_content;
                $size = 220;
                echo (mb_strlen($desc) > $size) ? mb_substr($desc, 0, mb_strrpos(mb_substr($desc, 0, $size, 'utf-8'), ' ', 0, 'utf-8'), 'utf-8') . '...' : $desc; ?>
            </p>
            <?php if (mb_strlen($desc) > $size): ?>
                <a data-title="<?= $comment->comment_author ?><?= get_comment_date($d = ', F jS Y', $comment) ?> <?= preg_replace('#^https?://#', '', $comment->comment_author_url); ?>"
                   data-text="<?= htmlspecialchars($desc) ?>" data-toggle="modal" class="triggerModal"
                   data-target="#commentModal"
                   href="#">Читать весь отзыв <img
                            src="/wp-content/themes/storefront-child/svg/svg-review__link.svg" alt="review-link"></a>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

// Display variation's price even if min and max prices are the same
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
    if ($value['price_html'] == '') {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}, 10, 3);

remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);

add_filter('woocommerce_checkout_fields', 'override_billing_checkout_fields', 20, 1);
function override_billing_checkout_fields($fields)
{
    $fields['billing']['billing_first_name']['placeholder'] = 'Как к вам обращаться?';
    $fields['billing']['billing_email']['placeholder'] = 'Укажите Email';
    return $fields;
}

function rudr_instagram_api_curl_connect($api_url)
{
    $connection_c = curl_init(); // initializing
    curl_setopt($connection_c, CURLOPT_URL, $api_url); // API URL to connect
    curl_setopt($connection_c, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
    curl_setopt($connection_c, CURLOPT_TIMEOUT, 20);
    $json_return = curl_exec($connection_c); // connect and get json data
    curl_close($connection_c); // close connection
    return json_decode($json_return); // decode and return
}

function wpb_woo_my_account_order()
{
    $myorder = array(
        'dashboard' => 'Мой аккаунт',
        'orders' => __('Orders', 'woocommerce'),
        'downloads' => 'Загрузки',
        'edit-account' => 'Настройки',
        'customer-logout' => __('Logout', 'woocommerce'),
    );
    return $myorder;
}

add_filter('woocommerce_account_menu_items', 'wpb_woo_my_account_order');

add_action('woocommerce_before_shop_loop_item_title', 'my_theme_wrapper_start', 9);

function my_theme_wrapper_start()
{

    global $product;
    // награда
    $award = (get_post_meta($product->get_id(), 'award', true));
    if ($award): ?>
        <div class="product-label-container" data-toggle="tooltip" data-placement="top" title='<?= $award; ?>'>
            <img alt='<?= $award; ?>' src="/wp-content/themes/storefront-child/images/img-award-products.png"/>
        </div>
    <?php endif;
}

remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

add_filter('login_url', function ($link) {
    $link = get_permalink(wc_get_page_id('myaccount'));
    return $link;
});

/**
 * Create the section beneath the products tab
 **/

add_filter('woocommerce_get_sections_products', 'wc_ajax_add_to_cart_variable_add_section');
function wc_ajax_add_to_cart_variable_add_section($sections)
{

    $sections['wc_ajax_add_to_cart_variable'] = __('WC Ajax for Variable Products', 'rc_wc_variable_ajax');
    return $sections;

}

add_filter('woocommerce_get_settings_products', 'wc_ajax_add_to_cart_variable_all_settings', 10, 2);

function wc_ajax_add_to_cart_variable_all_settings($settings, $current_section)
{

    /**
     * Check the current section is what we want
     **/

    if ($current_section == 'wc_ajax_add_to_cart_variable') {

        $settings_slider = array();

        // Add Title to the Settings
        $settings_slider[] = array('name' => __('WC Ajax for Variable Products Settings', 'rc_wc_variable_ajax'), 'type' => 'title', 'desc' => __('The following options are used to configure WC Ajax for Variable Products', 'rc_wc_variable_ajax'), 'id' => 'wc_ajax_add_to_cart_variable');

        // Add first checkbox option
        $settings_slider[] = array(

            'name' => __('Add Selection option to Category Page', 'rc_wc_variable_ajax'),
            'desc_tip' => __('This will automatically insert variable selection options on product Category Archive Page', 'rc_wc_variable_ajax'),
            'id' => 'wc_ajax_add_to_cart_variable_category_page',
            'type' => 'checkbox',
            'css' => 'min-width:300px;',
            'desc' => __('Enable Varition select option on Category Archive page', 'rc_wc_variable_ajax'),

        );

        $settings_slider[] = array('type' => 'sectionend', 'id' => 'wc_ajax_add_to_cart_variable');

        return $settings_slider;

        /**
         * If not, return the standard settings
         **/

    } else {

        return $settings;

    }

}

$category_page = get_option('wc_ajax_add_to_cart_variable_category_page');

if (isset($category_page) && $category_page == "yes") {

    if (!function_exists('woocommerce_template_loop_add_to_cart')) {

        function woocommerce_template_loop_add_to_cart($args = array())
        {
            global $product;

            $product_type = $product->get_type();

            if ($product) {
                $defaults = array(
                    'quantity' => 1,
                    'class' => implode(' ', array_filter(array(
                        'button',
                        'product_type_' . $product_type,
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : ''
                    ))),
                    'attributes' => array('data-product_id' => $product->id, 'data-product_sku' => $product->get_sku()),
                );

                $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($args, $defaults), $product);

                if ($product_type == "variable") {
                    woocommerce_variable_add_to_cart();
                } else {
                    wc_get_template('loop/add-to-cart.php', $args);
                }
            }
        }
    }
}

function ajax_add_to_cart_script()
{
    wp_enqueue_script('add-to-cart-variation_ajax', get_stylesheet_directory_uri() . '/inc/assets/js//add-to-cart-variation.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'ajax_add_to_cart_script', 99);

/* AJAX add to cart variable added by Rishi Mehta - rishi@rcreators.com */
add_action('wp_ajax_woocommerce_add_to_cart_variable_rc', 'woocommerce_add_to_cart_variable_rc_callback');
add_action('wp_ajax_nopriv_woocommerce_add_to_cart_variable_rc', 'woocommerce_add_to_cart_variable_rc_callback');

function woocommerce_add_to_cart_variable_rc_callback()
{
    ob_start();

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : apply_filters('woocommerce_stock_amount', $_POST['quantity']);
    $variation_id = $_POST['variation_id'];
    $variation = $_POST['variation'];
    if (!$variation_id) {
        //$variation_id = WC_Product_Variation::get_variation_id();
        echo json_encode($variation);
        die();
    }

    foreach ($variation as $key => $value) {
        $variation[$key] = stripslashes($value);
    }
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);
        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
            wc_add_to_cart_message($product_id);
        }
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        wc_setcookie('woocommerce_items_in_cart', count($items));
        wc_setcookie('woocommerce_cart_hash', md5(json_encode($items)));
        do_action('woocommerce_set_cart_cookies', true);
        // Return fragments
        WC_AJAX::get_refreshed_fragments();
    } else {
        $this->json_headers();

        // If there was an error adding to the cart, redirect to the product page to show any errors
        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
        );
        echo json_encode($data);
    }
    die();
}

add_filter('woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
function wc_refresh_mini_cart_count($fragments)
{
    ob_start();
    if (WC()->cart->get_cart_contents_count() !== 0):
        ?>
        <span id="basket-btn__counter">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
        </span>
    <?php
    endif;
    $fragments['#basket-btn__counter'] = ob_get_clean();
    return $fragments;

}

wp_enqueue_style('animate', get_stylesheet_directory_uri() . '/inc/assets/css/animate.css');
wp_enqueue_script('wow-js', get_stylesheet_directory_uri() . '/inc/assets/js/wow.min.js', array(), '', true);

//function products_in_cart()
//{
//    $parent = get_the_id(); // the parent product
//    $products_in_cart = array();
//    $cart_items = WC()->cart->get_cart();
//    foreach ($cart_items as $cart_item) {
//        if ($cart_item['product_id'] == $parent) {
//            $products_in_cart[] = $cart_item['variation']; // possibly array('attribute_pa_color'=>'black')
//
//        }
//    }
//    if (count($products_in_cart) > 0) {
//        return true;
//    } else {
//        return false;
//    }
//}

function changeBreadcrumbLinkProduct($crumbs)
{
    if (is_product()) {
        foreach (wp_get_post_terms(get_the_id(), 'product_cat') as $term) {
            if ($term) {
                $slug = $term->slug;
                $crumbs[1][1] = '/shop/#' . $slug;
                $crumbs[1][0] = $term->name;
            }
        }
    }

    return $crumbs;
}

add_filter('woocommerce_get_breadcrumb', 'changeBreadcrumbLinkProduct');

function remove_image_zoom_support()
{
    remove_theme_support('wc-product-gallery-zoom');
}

add_action('after_setup_theme', 'remove_image_zoom_support', 100);

add_filter('woocommerce_get_wp_query_args', function ($wp_query_args, $query_vars) {
    if (isset($query_vars['meta_query'])) {
        $meta_query = isset($wp_query_args['meta_query']) ? $wp_query_args['meta_query'] : [];
        $wp_query_args['meta_query'] = array_merge($meta_query, $query_vars['meta_query']);
    }
    return $wp_query_args;
}, 10, 2);

add_action('customize_register', 'mytheme_customize_register');
/**
 * Добавляет страницу настройки темы в админку Вордпресса
 */
function mytheme_customize_register($wp_customize)
{
    /*
    Добавляем секцию в настройки темы
    */
    $wp_customize->add_section(
    // ID
        'data_main_section',
        // Arguments array
        array(
            'title' => 'Данные главной страницы',
            'capability' => 'edit_theme_options',
            'description' => "Тут можно указать данные для главной страницы"
        )
    );
    $wp_customize->add_setting(
    // ID
        'author_image',
        // Arguments array
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
    // ID
        'author_image_control',
        // Arguments array
        array(
            'type' => 'url',
            'label' => "Ссылка на изображение автора",
            'section' => 'data_main_section',
            // This last one must match setting ID from above
            'settings' => 'author_image'
        )
    );
    $wp_customize->add_setting(
    // ID
        'main_about_1',
        // Arguments array
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
    // ID
        'main_about_1_control',
        // Arguments array
        array(
            'type' => 'textarea',
            'label' => "Об авторе - 1-й абзац",
            'section' => 'data_main_section',
            // This last one must match setting ID from above
            'settings' => 'main_about_1'
        )
    );
    $wp_customize->add_setting(
    // ID
        'main_about_2',
        // Arguments array
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
    // ID
        'main_about_2_control',
        // Arguments array
        array(
            'type' => 'textarea',
            'label' => "Об авторе - 2-й абзац",
            'section' => 'data_main_section',
            // This last one must match setting ID from above
            'settings' => 'main_about_2'
        )
    );
    $wp_customize->add_setting(
    // ID
        'instagram_text',
        // Arguments array
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
    // ID
        'instagram_text_control',
        // Arguments array
        array(
            'type' => 'textarea',
            'label' => "Текст блока Instagram",
            'section' => 'data_main_section',
            // This last one must match setting ID from above
            'settings' => 'instagram_text'
        )
    );
    $wp_customize->add_setting(
    // ID
        'facebook_text',
        // Arguments array
        array(
            'default' => '',
            'type' => 'option'
        )
    );
    $wp_customize->add_control(
    // ID
        'facebook_text_control',
        // Arguments array
        array(
            'type' => 'textarea',
            'label' => "Текст блока Facebook",
            'section' => 'data_main_section',
            // This last one must match setting ID from above
            'settings' => 'facebook_text'
        )
    );
}

function ql_woocommerce_ajax_add_to_cart_js()
{

    if (function_exists('is_product') && is_product()) {
        wp_enqueue_script('add-to-cart-single_ajax', get_stylesheet_directory_uri() . '/inc/assets/js//add-to-cart-single.js', array('jquery'), '', true);
    }
}

add_action('wp_enqueue_scripts', 'ql_woocommerce_ajax_add_to_cart_js');

add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');

add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');

function ql_woocommerce_ajax_add_to_cart()
{

    $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));

    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

    $variation_id = absint($_POST['variation_id']);

    $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('ql_woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {

            wc_add_to_cart_message(array($product_id => $quantity), true);

        }

        WC_AJAX:: get_refreshed_fragments();

    } else {

        $data = array(

            'error' => true,

            'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);

    }

    wp_die();

}

add_action('template_redirect', 'onlyBibliRedirect');

/**
 * Редирект на библиографию если книга только для неё
 */
function onlyBibliRedirect()
{
    global $product;
    global $post;
    if (!is_null($product) && get_post_meta($post->ID, 'only_bibli', true) === '1') {
        exit(wp_redirect(home_url('/bibliografiya/')));
    }

}

function post_id_by_term_id($term_id)
{
    global $wpdb;

    $ids = $wpdb->get_col($wpdb->prepare("SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term_id));
    return $ids;
}

// Удаление инлайн-скриптов из хедера
add_filter('storefront_customizer_css', '__return_false');
add_filter('storefront_customizer_woocommerce_css', '__return_false');
add_filter('storefront_gutenberg_block_editor_customizer_css', '__return_false');

add_action('wp_print_styles', function () {
    wp_styles()->add_data('woocommerce-inline', 'after', '');
});

//add_action('init', function () {
//    global $heateor_sss;
//    remove_action('wp_head', 'wc_gallery_noscript');
//    remove_action('wp_enqueue_scripts', array($heateor_sss->plugin_public, 'frontend_inline_style'));
//    add_action('wp_footer', function () {
//        global $heateor_sss;
//        echo '<style type="text/css">';
//        $heateor_sss->plugin_public->frontend_inline_style();
//        echo '</style>';
//    });
//
//});
// Конец удаления инлайн-скриптов из хедера

add_filter('wpseo_twitter_image', 'changeTwitterImage');
add_filter('wpseo_og_og_image', 'changeOGImage');

function changeTwitterImage($img) {
    return changeOGImage($img,'twitter');
}
function changeOGImage($img, $size = 'autodetect')
{
    return $img;

    if (!is_product()) {
        return $img;
    }
    if(!extension_loaded('imagick')) {
        return $img;
    }
    global $post;
    $originalImageUrl = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    $uploads = wp_upload_dir();
    $file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $originalImageUrl);
    require_once __DIR__ . '/evaSocialImgGenerator/evaSocialImgGenerator.php';
    require_once __DIR__ . '/evaSocialImgGenerator/evaSocialImgTextGenerator.php';
    $authorGenerator = new imgTextGenerator();
    $author = $authorGenerator
        ->seTextShadow('#000000',75, 1, 2, 2)
        ->setText('Мария Сакрытина',"#ffffff",imgGenerator::position_center_top,"1/15", ["10%","0%","0%","15%",]);
//        ->setFont($_SERVER["DOCUMENT_ROOT"] . '/wp-content/themes/storefront-child/inc/assets/fonts/Robotoslabregular.ttf');
    $titleGenerator = new imgTextGenerator();
    $title = $titleGenerator
        ->seTextShadow('#000000',75, 1, 2, 2)
        ->setText(get_the_title(),"#ffffff",imgGenerator::position_center_top,"1/15", ["20%","0%","0%","15%",]);
//        ->setFont($_SERVER["DOCUMENT_ROOT"] . '/wp-content/themes/storefront-child/inc/assets/fonts/Robotoslabregular.ttf');
    $generator = new imgGenerator();
    $path = $generator
        ->enableCache($uploads['basedir'])
        ->addText($author)
        ->addText($title)
        ->addOverlay(0.5, '#000000')
        ->setLogo($file_path, imgGenerator::position_left_bottom, ["10%","0%","10%","5%",],'auto')
        ->fromImg($file_path)
        ->resizeFor('autodetect')
        ->getPath();
    return $path;
}
