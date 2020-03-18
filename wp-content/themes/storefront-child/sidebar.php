<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area col-sm-12 col-lg-3 pr-0" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
    <div class="sidebar-cycles">
        <p class="sidebar-cycles__header">Циклы</p>
        <?php
        // since wordpress 4.5.0
        $args = array(
            'taxonomy' => "product_cat",
            'number' => $number,
            'orderby' => $orderby,
            'order' => $order,
            'hide_empty' => true,
            'include' => $ids
        );
        $product_categories = get_terms($args);
        foreach ($product_categories as $key => $cat):?>
            <?php if ($key !== 0 && $cat->slug !== 'storybooks'): ?>
                <p class="sidebar-cycles__item"><a class="link" href="#<?= $cat->slug ?>"><?= $cat->name ?></a></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="sidebar-cycles">
        <p class="sidebar-cycles__header">Сборники рассказов</p>
        <?php foreach ($product_categories as $cat):?>
            <?php if ($cat->slug === 'storybooks'): ?>
                <p class="sidebar-cycles__item"><a class="link" href="#<?= $cat->slug ?>"><?= $cat->name ?></a</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="sidebar-attention">
        <div class="sidebar-attention__body">
            <p class="sidebar-attention__header">Внимание</p>
            <img src="/wp-content/themes/storefront-child/svg/svg-attention.svg" alt="svg-attention">
            <p>Здесь размещены только полные тексты моих книг.</p>
            <p>Для скачивания нажмите на книгу и выберите формат. Если что-то пошло не так, пишите на <a href="mailto:maria@sakrytina.ru">maria@sakrytina.ru</a></p>
            <p>Скачивание моих книг на пиратских сайтах вредит вашей карме и компьютеру. Остерегайтесь мошенников!</p>
        </div>
    </div>
</aside><!-- #secondary -->
