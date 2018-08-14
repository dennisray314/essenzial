<?php
/**
 * ADMIN PAGE ESSENZIAL
 *
 */


class EssenzialPage
{

    private $options;


    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_essenzial_page' ) );
        add_action( 'admin_init', array( $this, 'essenzial_page_init' ) );
    }

    public function add_essenzial_page()
    {
        add_menu_page(
            'Settings Admin',
            'Basic Settings',
            'manage_options',
            'essenzial-setting-admin',
            array( $this, 'create_essenzial_admin_page' ),
            '',
            2
        );
    }

    public function create_essenzial_admin_page()
    {
        $this->options = get_option( 'essenzial_options' );
        ?>
        <div class="wrap">
            <h1>Evoluzione del Profumo Impostazioni</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'essenzial_option_group' );
                do_settings_sections( 'essenzial-setting-admin' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function essenzial_page_init()
    {
        register_setting(
            'essenzial_option_group', // Option group
            'essenzial_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'essenzial_setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'essenzial-setting-admin' // Page
        );


        add_settings_field(
            'title',
            'Codice Fiscale default per checkout',
            array( $this, 'text_callback' ),
            'essenzial-setting-admin',
            'essenzial_setting_section_id',
            array('paramName'=>'codiceFiscale')
        );
    }


    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['codiceFiscale'] ) )
            $new_input['codiceFiscale'] = sanitize_text_field( $input['codiceFiscale'] );

        return $new_input;
    }

    public function print_section_info()
    {
        print 'Sezione impostazioni Essenzial:';
    }


    public function text_callback($args)
    {
        $name = $args['paramName'];
        printf(
            '<input type="text" name="essenzial_options['.$name.']" value="%s" />',
            isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : ''
        );
    }
}