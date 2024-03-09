<?php
/**
* This file creates Admin menu page
*/

namespace includes;

use includes\Constants;

class CreateAdminMenu {

    private $slug = 'saucal-custom-api-woocommerce-data';

    public function __construct() {

        add_action( 'admin_menu', [ $this, 'create_admin_menu' ] );
        add_action( 'admin_init', [ $this, 'saucal_settings_fields' ] );
    }

    public function create_admin_menu() {

        $capability = 'manage_options';
        $slug = $this->slug;

        //Add new setting under settings
        add_options_page(
            __( 'saucal custom API woocommerce setting', 'Saucal' ),
            __( 'Saucal API setting', 'Saucal' ),
            $capability,
            $slug,
            [ $this, 'saucal_api_settings_callback' ],

        );

    }

    public function saucal_api_settings_callback() {
        ?>

        <div class = 'wrap'>
        <h1>  Saucal custom API woocommerce settings page     </h1>
        <p> Please Provide The API URL in the Text Box Below</p>
        </div>
        <form action = 'options.php' method = 'post'>

        <?php
        settings_fields( 'saucal_api_url_setting' );
        do_settings_sections( $this->slug );
        submit_button();
        ?>
        </form>

    <?php }



    public function saucal_settings_fields() {
        add_settings_section(
            'custom_api_settings_section',
            __( '<h1>Custom API woocommerce settings</h2>', 'saucal' ),
            null,
            $this->slug
        );

        add_settings_field(
            Constants::API_URL,
            __( 'Custom API url:', 'saucal' ),
            [ $this, 'custom_api_url_field_cb' ],
            $this->slug,
            'custom_api_settings_section'
        );

        register_setting( 'saucal_api_url_setting', 'custom_api_url_field' );

    }

    public function custom_api_url_field_cb() {
        ?>
        <input type = 'text' id = 'custom_api_url' name = 'custom_api_url_field'  value = '<?php esc_attr_e(get_option('custom_api_url_field'))?>' >
        <?php
    }

}

