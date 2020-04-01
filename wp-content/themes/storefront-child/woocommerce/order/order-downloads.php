<?php
/**
 * Order Downloads.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="woocommerce-order-downloads">

    <table class="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
        <thead>
        <tr>
            <?php foreach (wc_get_account_downloads_columns() as $column_id => $column_name) : ?>
                <?php if ($column_id !== 'download-remaining' && $column_id !== 'download-expires'): ?>
                    <th class="<?php echo esc_attr($column_id); ?>"><span
                                class="nobr"><?php echo esc_html($column_name); ?></span></th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        </thead>

        <?php
        $groupedDownloads = array();

        foreach ($downloads as $download) {
            if (!key_exists($download['product_id'], $groupedDownloads)) {
                $groupedDownloads[$download['product_id']] = $download;
            }
            $groupedDownloads[$download['product_id']]['files'][] = array_merge($download['file'], ['download_url' => $download['download_url']]);
        }
        ?>
        <?php foreach ($groupedDownloads as $download) : ?>
            <tr>
                <?php foreach (wc_get_account_downloads_columns() as $column_id => $column_name) : ?>
                    <?php if ($column_id !== 'download-remaining' && $column_id !== 'download-expires'): ?>

                        <td class="<?php echo esc_attr($column_id); ?>"
                            data-title="<?php echo esc_attr($column_name); ?>">
                            <?php
                            if (has_action('woocommerce_account_downloads_column_' . $column_id)) {
                                do_action('woocommerce_account_downloads_column_' . $column_id, $download);
                            } else {
                                switch ($column_id) {
                                    case 'download-product':
                                        if ($download['product_url']) {
                                            echo '<a href="' . esc_url($download['product_url']) . '">' . esc_html($download['product_name']) . '</a>';
                                        } else {
                                            echo esc_html($download['product_name']);
                                        }
                                        break;
                                    case 'download-file':
                                        foreach ($download['files'] as $key => $file) {
                                            echo '<a href="' . esc_url($file['download_url']) . '" class="download-link">';
                                            echo esc_html($file['name']);
                                            if (count($download['files']) !== 0 && count($download['files']) - 1 !== $key) {
                                                echo '</a>, ';
                                            } else {
                                                echo '</a>';
                                            }
                                        }
                                        break;
                                }
                            }
                            ?>
                        </td>
                    <?php endif; ?>

                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
