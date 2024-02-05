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

    //Retrieve cache data
    $cache = get_transient('saucal_api_results');

    if($cache){
        $data = json_decode($cache, true);
        return $data;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    //save result in cache for 12 hours
    set_transient('saucal_api_results', json_encode($data['headers']), 60*60*12 );

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
    $user_preferences = explode(",", $preference);
    $data = fetch_api_data($user_preferences);

    $content = file_get_contents(SAUCAL_PATH . 'templates/tab-frontend.php');


    printf($content,
        $preference, $data['Accept'],
        $data['Accept-Encoding'],
        $data['Content-Length'],
        $data['Content-Type'],
        $data['Host'],
        $data['User-Agent'],
        $data['X-Amzn-Trace-Id']
    );

}
);

add_action('init', function () {
    add_rewrite_endpoint('saucal_api_custom_tab', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}
);

require_once SAUCAL_PATH . 'includes/create-admin-menu.php';
require_once SAUCAL_PATH . 'includes/widget.php';