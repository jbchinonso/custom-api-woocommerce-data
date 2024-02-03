<?php

// Add a new tab in My Account section
add_filter('woocommerce_account_menu_items', function ($menu_items) {
    $menu_items['saucal_api_custom_tab'] = 'Saucal API Tab';
    return $menu_items;
}
);

// Display content under the custom tab
add_action('woocommerce_account_saucal_api_custom_tab_endpoint', function () {

    $user_id = get_current_user_id();
    if (isset($_POST['api-preferences'])) {
        update_user_meta($user_id, 'api-preferences', sanitize_text_field($_POST['api-preferences']));
    }

    $preference = get_user_meta($user_id, 'api-preferences', true);

    $controls = '<h1> Please Enter your Preferences in the Box below</h1>
            <form action = "" method = "post">
                <div class="control">
                    <label for="api-preferences">Preferences</label>
                    <input type="text" name="api-preferences" id="api-preferences" value="%s" placeholder="phones,laptops,tablets">
                </div>

                <input type="submit" value="Save">
             </form>';
     printf($controls, $preference);

}
);

add_action('init', function () {
    add_rewrite_endpoint('saucal_api_custom_tab', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}
);
