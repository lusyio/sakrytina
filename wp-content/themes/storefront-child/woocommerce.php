<?php
/**
 * The template for displaying Woocommerce Product
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<?php if (is_product() || is_cart() || is_checkout()): ?>
    <section id="primary" class="content-area col-sm-12 mt-5">
        <main id="main" class="site-main" role="main">

            <?php woocommerce_content(); ?>
            <?php
            if (is_product()) {
                comments_template();
            } ?>
        </main><!-- #main -->
    </section><!-- #primary -->
<?php else: ?>
    <section id="primary" class="content-area col-sm-12 col-lg-8 archive-product-page">
        <main id="main" class="site-main" role="main">
            <?php woocommerce_content(); ?>
        </main><!-- #main -->
    </section><!-- #primary -->
    <div class="col-1"></div>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php
get_footer();
