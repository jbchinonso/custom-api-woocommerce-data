<?php

class Saucal_Api_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'saucal_api_widget',
            __( 'Saucal API Widget', 'saucal' ),
            array( 'description' => __( 'Sample widget that returns api data based on user preferences', 'saucal' ), )
        );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );

        echo $args[ 'before_widget' ];
        if ( ! empty( $title ) )
        echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];

        $user_id = get_current_user_id();
        $preference = get_user_meta( $user_id, 'api-preferences', true );
        $user_preferences = explode( ',', $preference );
        $data = fetch_api_data( $user_preferences );

        $content = file_get_contents(SAUCAL_PATH . 'templates/widget-frontend.php');


        printf( $content, $data[ 'Accept' ],
        $data[ 'Accept-Encoding' ],
        $data[ 'Content-Length' ],
        $data[ 'Content-Type' ],
        $data[ 'Host' ],
        $data[ 'User-Agent' ],
        $data[ 'X-Amzn-Trace-Id' ] );

        echo $args[ 'after_widget' ];

    }


    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ):
            $title = $instance[ 'title' ];
        else:
            $title = __( 'New title', 'saucal' );
        endif
        // Widget admin form
        ?>
        <p>
        <label for = "<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' );?></label>
        <input class = 'widget' id = "<?php echo $this->get_field_id( 'title' ); ?>" name = "<?php echo $this->get_field_name( 'title' ); ?>" type = 'text' value = "<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        return $instance;
    }

}

function saucal_load_widget() {
    register_widget( 'Saucal_Api_Widget' );
}
add_action( 'widgets_init', 'saucal_load_widget' );