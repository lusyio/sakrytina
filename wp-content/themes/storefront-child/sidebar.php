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

<aside id="secondary" class="widget-area col-sm-12 col-lg-3 pr-lg-0 pr-unset" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
    <div class="sidebar-cycles">
        <p class="sidebar-cycles__header">Циклы</p>
        <?php
        // since wordpress 4.5.0
        $args = array(
            'taxonomy' => "product_cat",
            'number' => '',
            'hide_empty' => true,
            'include' => ''
        );
        $product_categories = get_terms($args);
        foreach ($product_categories as $key => $cat):?>
            <?php if (isset($GLOBALS['emptyCategories']) && in_array($cat->slug, $GLOBALS['emptyCategories'])){
                continue;
                } ?>
            <?php if ($cat->slug !== 'sbornik-rasskazov'): ?>
                <p class="sidebar-cycles__item">
                    <a class="link" href="#<?= $cat->slug ?>"><?= $cat->name ?></a>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="sidebar-cycles">
        <?php
        $i = 0;
        foreach ($product_categories as $cat): ?>
            <?php if ($cat->slug === 'sbornik-rasskazov'):
                if ($i === 0){
                    echo '<p class="sidebar-cycles__header">Сборники рассказов</p>';
                }
                $productsCat = wc_get_products(array(
                    'category' => array($cat->slug),
                ));
                foreach ($productsCat as $productCat):
                    ?>
                    <p class="sidebar-cycles__item">
                        <a class="link" href="#<?= $cat->slug ?>"><?= $productCat->name ?></a
                    </p>
                <?php
                $i++;
                endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="sidebar-attention">
        <div class="sidebar-attention__body">
            <p class="sidebar-attention__header">Внимание</p>
            <img src="/wp-content/themes/storefront-child/svg/svg-attention.svg" alt="svg-attention">
            <p>Здесь размещены только полные тексты моих книг.</p>
            <p>Для скачивания нажмите на книгу и выберите формат. Если что-то пошло не так, пишите на <a
                        href="mailto:maria@sakrytina.ru">maria@sakrytina.ru</a></p>
            <p>Скачивание моих книг на пиратских сайтах вредит вашей карме и компьютеру. Остерегайтесь мошенников!</p>
        </div>
    </div>
</aside><!-- #secondary -->
