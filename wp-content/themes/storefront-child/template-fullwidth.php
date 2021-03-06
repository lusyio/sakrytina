<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full width
 *
 * @package storefront
 */

get_header(); ?>

    <div id="primary" class="content-area  col-sm-12 <?= is_cart() ? 'p-0 pl-lg-3 pr-lg-3' : '' ?> <?= (is_checkout() && !empty( is_wc_endpoint_url('order-received'))) ? 'thank-you-page' : '' ?>">
        <main id="main" class="site-main" role="main">

            <?php
            while (have_posts()) :
                the_post();

                do_action('storefront_page_before');

                get_template_part('content', 'page');

                /**
                 * Functions hooked in to storefront_page_after action
                 *
                 * @hooked storefront_display_comments - 10
                 */
                do_action('storefront_page_after');

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
