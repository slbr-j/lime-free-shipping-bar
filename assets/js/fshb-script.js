jQuery(document).ready(function ($) {
    function updateFreeShippingBar() {
        $.ajax({
            url: fshb_params.ajax_url,
            type: 'POST',
            data: {
                action: 'fshb_update_free_shipping_bar',
                nonce: fshb_params.nonce,
                lang: fshb_params.lang
            },
            success: function (response) {
                if (response.success) {
                    $('.free-shipping-bar').replaceWith(response.data.html);
                }
            }
        });
    }

    // Updating the top-bar on page load
    updateFreeShippingBar();

    // Updating the top-bar when adding or removing items from the cart
    $('body').on('added_to_cart removed_from_cart', function () {
        updateFreeShippingBar();
    });
});
