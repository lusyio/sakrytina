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
    <section id="primary" class="content-area <?= is_product() ? 'p-0 pl-lg-3 pr-lg-3' : '' ?> col-sm-12 mt-5 ">
        <main id="main" class="site-main" role="main">

            <?php woocommerce_content(); ?>
        </main><!-- #main -->
            <?php if (is_product()): ?>
                <?php
                    global $post;
                    $showList = false;
                    $terms = get_the_terms( $post->ID, 'product_cat' );
                    foreach ($terms as $term) {
                        if ($term->slug == 'sbornik-rasskazov') {
                            $showList = true;
                            break;
                        }
                    }
                ?>
                <?php
                    if (isset($showList) && $showList):
                        $articles = [];
                        $afterMore = preg_split('~<!--more-->~', $post->post_content, 2);
                        if (count($afterMore) > 1) {
                            preg_match_all('~<li>(.+)</li>~mU', $afterMore[1], $articles);
                        }
                        $firstColumnCount = 0;
                        if (count($articles) > 1):
                            $articlesNumber = count($articles[1]);
                            $firstColumnCount = ceil($articlesNumber / 2);
                        ?>
        <div class="product-card">
            <div class="product-card__main-body">
                <h4 class="text-center">Рассказы в сборнике</h4>
                <div class="blockStory">
                    <div class="row">
                            <?php foreach ($articles[1] as $key => $articleName):?>
                                <?php if ($key == 0 || $key == $firstColumnCount): ?>
                        <div class="col-sm-6">
                            <ul>
                                <?php endif; ?>
                                <li><?php echo $articleName ?></li>
                                <?php if ($key == $firstColumnCount - 1 || $key == $articlesNumber): ?>
                            </ul>
                        </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>


            </section><!-- #primary -->
    <?php
    if (is_product()) {
        comments_template();
    } ?>
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
