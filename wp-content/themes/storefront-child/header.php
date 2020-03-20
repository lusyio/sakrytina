<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action('storefront_before_site'); ?>

<div id="page" class="hfeed site">
    <?php do_action('storefront_before_header'); ?>

    <header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">

        <div class="container">
            <nav class="navbar navbar navbar-expand-xl p-0 justify-content-between">
                <div class="navbar-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="/wp-content/themes/storefront-child/svg/svg-sakrytina-icon.svg"
                             alt="sakrytina-icon">
                    </a>
                </div>

                <div class="d-flex menu-container">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => 'div',
                        'container_id' => '',
                        'container_class' => 'collapse navbar-collapse mr-5',
                        'menu_id' => false,
                        'menu_class' => 'navbar-nav',
                        'depth' => 3,
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => new wp_bootstrap_navwalker()
                    ));
                    ?>
                    <?php if (class_exists('WooCommerce')): ?>
                        <div class="s-header__basket-wr woocommerce mr-1 mr-sm-4 mt-auto mb-auto z-5 position-relative">
                            <a href="<?= esc_url(wc_get_cart_url()) ?>"
                               class="basket-btn basket-btn_fixed-xs text-decoration-none position-relative">
                                <span class="basket-btn__label">
                                    <img src="/wp-content/themes/storefront-child/svg/svg-cart.svg"
                                         alt="cart">
                                </span>
                                    <span id="basket-btn__counter"></span>
                                Корзина
                            </a>
                        </div>
                        <div class="m-auto">
                            <?php if (is_user_logged_in()) { ?>
                                <a class="btn btn-primary"
                                   href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                                   title="<?php _e('My Account', 'woothemes'); ?>"><img
                                            src="/wp-content/themes/storefront-child/svg/svg-your-account.svg"
                                            alt="your-account"> Личный кабинет
                                </a>
                            <?php } else { ?>
                                <a class="btn btn-primary"
                                   href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                                   title="<?php _e('Login / Register', 'woothemes'); ?>"> <img
                                            src="/wp-content/themes/storefront-child/svg/svg-your-account.svg"
                                            alt="your-account"> Личный кабинет
                                </a>
                            <?php } ?>
                        </div>
                    <?php endif; ?>

                    <div class="outer-menu">
                        <button class="navbar-toggler position-relative" type="button" style="z-index: 1">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <input class="checkbox-toggle" data-toggle="collapse" data-target="#main-nav"
                               aria-controls="" aria-expanded="false" aria-label="Toggle navigation" type="checkbox"/>
                        <div class="menu">
                            <div>
                                <div class="border-header">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary',
                                        'container' => 'div',
                                        'container_id' => 'main-nav',
                                        'container_class' => 'collapse navbar-collapse justify-content-end',
                                        'menu_id' => false,
                                        'menu_class' => 'navbar-nav',
                                        'depth' => 3,
                                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                        'walker' => new wp_bootstrap_navwalker()
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

    </header><!-- #masthead -->

    <?php
    /**
     * Functions hooked in to storefront_before_content
     *
     * @hooked storefront_header_widget_region - 10
     * @hooked woocommerce_breadcrumb - 10
     */
    do_action('storefront_before_content');
    ?>

    <div id="content" class="site-content">
        <div class="container">
            <div class="row">

<?php
do_action('storefront_content_top');

