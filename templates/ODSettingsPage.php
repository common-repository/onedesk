<?php
class OneDeskSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    public $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings" called OneDesk Plugin
        
        add_options_page( 'My Plugin Options', 'OneDesk Plugin', 'manage_options', 'odwidget-settings', array($this, 'create_admin_page') );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'od_option_name' );
        ?>
        <div class="wrap">
            <h1>OneDesk Widget Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'od_option_group' );
                do_settings_sections( 'odwidget-settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'od_option_group', // Option group
            'od_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'URI_section', // Section Name
            'Organization Info (required)', // Title
            array( $this, 'print_URI_section_info' ), // Callback
            'odwidget-settings' // Page
        );  

        add_settings_section(
            'position_section', // Section Name
            'Positioning Options', // Title
            array( $this, 'print_position_section_info' ), // Callback
            'odwidget-settings' // Page
        );  

        add_settings_section(
            'color_section', // Section Name
            'Color Options', // Title
            array( $this, 'print_color_section_info' ), // Callback
            'odwidget-settings' // Page
        );  
        

        add_settings_field(
            'org_name', //setting name
            'URI', //Title
            array( $this, 'org_name_callback' ), //Callback
            'odwidget-settings', //Page Identifier
            'URI_section' //Settings Section
        );    

        add_settings_field(
            'origin', 
            'Location (left/right)', 
            array( $this, 'origin_callback',  ), 
            'odwidget-settings', 
            'position_section'
        );     
        
        add_settings_field(
            'x_pos', 
            'X Position (pixels)', 
            array( $this, 'x_pos_callback' ), 
            'odwidget-settings', 
            'position_section'
        );

        add_settings_field(
            'y_pos', 
            'Y Position (pixels)', 
            array( $this, 'y_pos_callback' ), 
            'odwidget-settings', 
            'position_section'
        );

        add_settings_field(
            'open_color', 
            'Open Color', 
            array( $this, 'open_color_callback' ), 
            'odwidget-settings', 
            'color_section'
        );

        add_settings_field(
            'close_color', 
            'Close Color', 
            array( $this, 'close_color_callback' ), 
            'odwidget-settings', 
            'color_section'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        if( isset( $input['org_name'] ) )
            $new_input['org_name'] = strtolower(sanitize_text_field( $input['org_name'])); //lowercase necessary
        
        if( isset( $input['origin'] ) )
            $new_input['origin'] = strtolower(sanitize_text_field( $input['origin'])); //lowercase necessary

        if( isset( $input['x_pos'] ) )
            $new_input['x_pos'] = absint( $input['x_pos']);
        
        if( isset( $input['y_pos'] ) )
            $new_input['y_pos'] = absint($input['y_pos']); 
        
        if( isset( $input['open_color'] ) )
            $new_input['open_color'] = strtolower(sanitize_text_field( $input['open_color'])); //lowercase necessary
        
        if( isset( $input['close_color'] ) )
            $new_input['close_color'] = strtolower(sanitize_text_field( $input['close_color'])); //lowercase necessary

        return $new_input;
    }

    /** 
     * Print the Section text to provide additional info for the function of each setting
     */
    public function print_URI_section_info()
    {
        print 'Enter your company URI below (ex: tickets@<em><strong>acme</strong></em>.onedesk.com -> URI=acme).';
    }

    public function print_position_section_info()
    {
        print 'Choose preferred bottom corner for the icon and its X postion and Y position. X and Y positions are measured as the pixel distance from this corner.';
    }

    public function print_color_section_info()
    {
        print 'Choose a color for the widget either entered as a word (blue, green, yellow, etc.) or as a hexadecimal value (ex: default = #25aed8).';
    }




    /** 
     * Get the settings option array and print one of its values
     */
    public function org_name_callback()
    {
        printf(
            '<input type="text" id="org_name" name="od_option_name[org_name]" value="%s" />',
            isset( $this->options['org_name'] ) ? esc_attr( $this->options['org_name']) : ''
        );
    }

    public function origin_callback()
    {
        printf(
            '<input type="text" id="origin" name="od_option_name[origin]" value="%s" />',
            isset( $this->options['origin'] ) ? esc_attr( $this->options['origin']) : 'right'
        );
    }

    public function x_pos_callback()
    {
        printf(
            '<input type="text" id="x_pos" name="od_option_name[x_pos]" value="%s" />',
            isset( $this->options['x_pos'] ) ? esc_attr( $this->options['x_pos']) : '20'
        );
    }

    public function y_pos_callback()
    {
        printf(
            '<input type="text" id="y_pos" name="od_option_name[y_pos]" value="%s" />',
            isset( $this->options['y_pos'] ) ? esc_attr( $this->options['y_pos']) : '20'
        );
    }

    public function open_color_callback()
    {
        printf(
            '<input type="text" id="open_color" name="od_option_name[open_color]" value="%s" />',
            isset( $this->options['open_color'] ) ? esc_attr( $this->options['open_color']) : '#25aed8'
        );
    }

    public function close_color_callback()
    {
        printf(
            '<input type="text" id="close_color" name="od_option_name[close_color]" value="%s" />',
            isset( $this->options['close_color'] ) ? esc_attr( $this->options['close_color']) : '#25aed8'
        );
    }
}

if( is_admin() )
    //initialize the settings page
    $od_settings_page = new OneDeskSettingsPage();