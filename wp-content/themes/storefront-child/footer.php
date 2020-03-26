<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

</div><!-- .row -->
</div><!-- .container -->

<?php if (is_product()) {
    get_template_part('template-parts/popular', 'popular');
} ?>

<?php do_action('storefront_before_footer'); ?>

<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a data-dismiss="modal"><img src="/wp-content/themes/storefront-child/svg/svg-close-modal.svg"
                                         alt="close-modal"></a>
            <div class="modal-body">
                <h5 class="modal-title comment-title-target"></h5>
                <div>
                    <p class="comment-content-target"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center col-lg-4 text-lg-left footer-logo mb-lg-0 mb-4">
                <div class="site-info">
                    <a class="site-title"
                       href="<?php echo esc_url(home_url('/')); ?>"><?php esc_url(bloginfo('name')); ?>
                        <p class="mb-0 site-description"><?php bloginfo('description'); ?></p>
                    </a>
                </div><!-- close .site-info -->
            </div>
            <div class="col-12 text-center col-lg-5 m-auto">
                <div class="row">
                    <?php
                    if ($menu_items = wp_get_nav_menu_items('second')) {
                        $menu_list = '';
                        echo '<div class="footer-menu">';
                        echo '<ul class="menu" id="menu-second">';
                        foreach ((array)$menu_items as $key => $menu_item) {
                            $title = $menu_item->title; // заголовок элемента меню (анкор ссылки)
                            $url = $menu_item->url; // URL ссылки
                            echo '<li><a class="link-strike" href="' . $url . '">' . $title . '</a></li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex m-auto justify-content-between">
                <p class="mb-0 d-lg-none d-block">
                    <a class="link-strike" href="/terms/">Политика конфиденциальности</a>
                </p>
            </div>
            <div class="col-12 d-lg-block d-none footer-socials text-center col-lg-3 text-lg-right m-auto">
                <p class="mb-0 footer-credits d-block">
                    <a class="credits" href="https://richbee.ru/"
                       target="_blank"><img src="/wp-content/themes/storefront-child/svg/Richbee-white.svg" alt=""></a>
                </p>
            </div>
            <div class="col-12">
                <hr>
                <div class="col-12 d-lg-none d-block footer-socials text-center col-lg-3 text-lg-right">
                    <p class="mb-0 footer-credits d-block">
                        <a class="credits" href="https://richbee.ru/"
                           target="_blank"><img src="/wp-content/themes/storefront-child/svg/Richbee-white.svg" alt=""></a>
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="footer-name-p mb-0 m-auto m-lg-0">
                        <?php echo date('Y'); ?>
                        &copy; <?php echo '<a class="link-strike" href="' . home_url() . '">' . get_bloginfo('name') . '</a>'; ?>

                    </p>
                    <p class="mb-0 d-lg-block d-none">
                        <a class="link-strike" href="/terms/">Политика конфиденциальности</a>
                    </p>
                </div>
            </div>
        </div>

    </div>


    <div class="col-full d-none">

        <?php
        /**
         * Functions hooked in to storefront_footer action
         *
         * @hooked storefront_footer_widgets - 10
         * @hooked storefront_credit         - 20
         */
        do_action('storefront_footer');
        ?>

    </div><!-- .col-full -->
</footer><!-- #colophon -->

<?php do_action('storefront_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
