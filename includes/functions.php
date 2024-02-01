<?php

// Add a new tab in My Account section
add_filter('woocommerce_account_menu_items', function ($menu_items) {
    $menu_items['saucal_api_custom_tab'] = 'Saucal API Tab';
    return $menu_items;
}
);

// Display content under the custom tab
add_action('woocommerce_account_saucal_api_custom_tab_endpoint', function () {
    ?>
    <h1> This is the custom Data from API</h1>
<?php
}
);

add_action('init', function () {
    add_rewrite_endpoint('saucal_api_custom_tab', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}
);
