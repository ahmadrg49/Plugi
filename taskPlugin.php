<?php 

/*
    Plugin Name: taskPlugin
    description: >-
    Setting up configurable fields for our plugin.
    Author: Matthew Ray
    Version: 1.0.0
*/

class TaskPlugin_Fields {
    // Our code will go here
    public function __construct() {


    // Hook into the admin menu
    add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );

    add_action( 'admin_init', array( $this, 'setup_sections' ) );

    add_action( 'admin_init', array( $this, 'setup_fields' ) );


    }

    public function create_plugin_settings_page() {
    // Add the menu item and page
    $page_title = 'My Settings Page';
    $menu_title = 'TaskPlugin';
    $capability = 'manage_options';
    $slug = 'smashing_fields';
    $callback = array( $this, 'plugin_settings_page_content' );
    $icon = 'dashicons-admin-plugins';
    $position = 100;

    add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );

    }


    public function plugin_settings_page_content() { ?>
    <div class="wrap">
        <h2>TaskPlugin</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'smashing_fields' );
                do_settings_sections( 'smashing_fields' );
                submit_button();
            ?>
        </form>
    </div> <?php
    }



    public function setup_sections() {
    add_settings_section( 'our_first_section', 'Plugin Settings', array( $this, 'section_callback' ), 'smashing_fields' );
    }


    public function section_callback( $arguments ) {
    switch ( $arguments['id'] ){
        case 'our_first_section':
            //echo 'This is the first description here!';
            break;
    }
    }

    public function setup_fields() {
            $fields = array(
                array(
                    'uid' => 'shortcode_name',
                    'label' => 'Choose a name:',
                    'section' => 'our_first_section',
                    'type' => 'text',
                    'options' => false,
                    'placeholder' => 'Choose the name',
                    'helper' => 'Does this help?',
                    'supplemental' => 'I am underneath!',
                    'default' => ''
                ),
                array(
                    'uid' => 'shortcode_shows',
                    'label' => 'Choose what shows:',
                    'section' => 'our_first_section',
                    'type' => 'text',
                    'options' => false,
                    'placeholder' => 'Choose the name',
                    'helper' => 'Does this help?',
                    'supplemental' => 'I am underneath!',
                    'default' => ''
                )
            ); 
        foreach( $fields as $field ){
            add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'smashing_fields', $field['section'], $field );
            register_setting( 'smashing_fields', $field['uid'] );
        }
    }

public function field_callback( $arguments ) {
    $value = get_option( $arguments['uid'] ); // Get the current value, if there is one
    if( ! $value ) { // If no value exists
        $value = $arguments['default']; // Set to our default
    }

    // Check which type of field we want
    switch( $arguments['type'] ){
        case 'text': // If it is a text field
            printf( '<input name="%1$s" id="%1$s" type="text" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );

            break;
    }
}
}
new TaskPlugin_Fields();

function changeNameShortcode($name) {
/*    extract(shortcode_atts(array(
        'name' => ''
    ), $name));
*/
    
    $args = shortcode_atts( 
    array(
        'name'   => ''
    ), 
    $name
);
    
    // check what type user entered
    $name = $args['name'];
    $h = 'Hello! ';
    if (!empty($name)) {
    switch ($name) {
        case get_option('shortcode_name'):
            return $h . get_option('shortcode_shows');
        default: 
        return $h . 'world!';
    } }
}
add_shortcode('code', 'changeNameShortcode');

?>