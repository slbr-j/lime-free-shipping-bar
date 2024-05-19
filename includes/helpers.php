<?php

function fshb_get_free_shipping_bar_content($lang = 'en') {
    $threshold = get_option('fshb_threshold', 500);
    $currency = get_option("fshb_currency_{$lang}", esc_html__('UAH', 'lime-free-shipping-bar'));
    $free_shipping_for_orders_over_message = get_option("fshb_free_shipping_for_orders_over_{$lang}", esc_html__('Free shipping for orders over {amount}', 'lime-free-shipping-bar'));
    $free_shipping_message = get_option("fshb_free_shipping_message_{$lang}", esc_html__('Congratulations, you get free shipping!', 'lime-free-shipping-bar'));
    $insufficient_amount_message = get_option("fshb_insufficient_amount_message_{$lang}", esc_html__('{amount} to get free shipping', 'lime-free-shipping-bar'));

    $current_total = WC()->cart->subtotal;
    $progress_percentage = ($current_total / $threshold) * 100;

    if ($current_total >= $threshold) {
        $message = $free_shipping_message;
    } elseif ($current_total > 0) {
        $difference = $threshold - $current_total;
        $amount_html = '<span style="color:' . esc_attr(get_option('fshb_amount_color', '#ff0000')) . '">' . number_format($difference, 0) . ' ' . esc_html($currency) . '</span>';
        $message = str_replace('{amount}', $amount_html, $insufficient_amount_message);
    } else {
        $amount_html = esc_html($threshold) . ' ' . esc_html($currency);
        $message = str_replace('{amount}', $amount_html, $free_shipping_for_orders_over_message);
    }

    $bar_background_color = esc_attr(get_option('fshb_bar_background_color', '#f2f2f2'));
    $text_color = esc_attr(get_option('fshb_text_color', '#4caf50'));
    $progress_bar_color = esc_attr(get_option('fshb_progress_bar_color', '#4caf50'));
    $progress_bar_background_color = esc_attr(get_option('fshb_progress_bar_background_color', '#ddd'));

    ob_start();
    ?>
    <div class="free-shipping-bar" style="background-color: <?php echo $bar_background_color; ?>; color: <?php echo $text_color; ?>;">
        <div class="message"><?php echo wp_kses($message, array(
            'span' => array(
                'style' => array()
            ),
        )); ?></div>
        <div class="progress-container" style="background-color: <?php echo $progress_bar_background_color; ?>;">
            <div class="progress-bar" style="width: <?php echo $progress_percentage; ?>%; background-color: <?php echo $progress_bar_color; ?>;"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
