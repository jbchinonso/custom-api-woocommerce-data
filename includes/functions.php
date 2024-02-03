<?php

function fetch_api_data($preferences)
{
    $api_url = sanitize_url(get_option('custom_api_url_field'));

    $response = wp_remote_post($api_url, array(
        'body' => json_encode($preferences),
        'headers' => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data['headers'];
}

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
