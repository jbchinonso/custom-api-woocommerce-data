<?php

function fetch_api_data($preferences)
{
    $api_url = sanitize_url(get_option(API_URL));

    //Retrieve cached data
    $cache = get_transient(CACHE_NAME);

    if($cache){
        $data = json_decode($cache, true);
        return $data;
    }

    $response = wp_remote_post($api_url, array(
        'body' => json_encode($preferences),
        'headers' => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    //save result in cache for 12 hours
    set_transient(CACHE_NAME, json_encode($data['headers']), 60*60*12 );

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
        if(isset($_POST['saucal_nonce']) && wp_verify_nonce($_POST['saucal_nonce'], "")){
            
            update_user_meta($user_id, USER_PREFERENCE, sanitize_text_field($_POST['api-preferences']));
        }
    }

    $preference = get_user_meta($user_id, USER_PREFERENCE, true);
    $user_preferences = explode(",", $preference);
    $data = fetch_api_data($user_preferences);

    $content = file_get_contents(SAUCAL_PATH . 'templates/tab-frontend.php');
    $nonce_fields = wp_nonce_field("", "saucal_nonce");

    printf($content, 
        $preference, $nonce_fields,
        $data['Accept'],
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