<div class="popular-block">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <p class="popular-block__header">Популярное</p>
                <div class="row">
                    <?php
                    $args = array(
                        'status' => 'publish',
                        'orderby' => 'order_clause',
                        'order' => 'DESC',
                        'meta_query' => array(
                            'order_clause' => array(
                                'key' => 'total_sales',
                                'value' => 'some_value',
                                'type' => 'NUMERIC' // unless the field is not a number
                            )),
                        'limit' => 4,
                    );
                    $query = new WC_Product_Query($args);
                    $products = $query->get_products();
                    foreach ($products as $product):
                        ?>
                        <div class="col-3">
                            <div class="popular-block-card">
                                <a href="<?php echo $product->get_permalink(); ?>">
                                    <div class="popular-block-card__img">
                                        <?php echo $product->get_image('medium'); ?>
                                    </div>
                                    <p class="popular-block-card__title"><?php echo $product->get_name(); ?></p>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>