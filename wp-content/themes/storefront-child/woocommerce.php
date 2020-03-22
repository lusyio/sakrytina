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
        <div class="product-card d-none">
            <div class="product-card__main-body">
                <h4 class="text-center">Рассказы в сборнике</h4>
                <div class="blockStory">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul>
                                <li>«Вечная молодость»</li>
                                <li>«Вьюга»</li>
                                <li>«Мальчик по вызову»</li>
                                <li>«Я буду любить тебя вечно»</li>
                                <li>«Не к той блондинке сунулся!»</li>
                                <li>«Всё будет хорошо, детка!»</li>
                                <li>«А вы верите в сказки?»</li>
                                <li>«Легенда»</li>
                                <li>«Взлетай»</li>
                                <li>«Моя Снежинка»</li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul>
                                <li>«Лунный идальго»</li>
                                <li>«Он и Она»</li>
                                <li>«Скрипка»</li>
                                <li>«Тающий лёд»</li>
                                <li>«Любовь зла»</li>
                                <li>«Я всё ещё здесь»</li>
                                <li>«Я закрываю глаза»</li>
                                <li>«Скажи да мне или нет»</li>
                                <li>«Приворот»</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
