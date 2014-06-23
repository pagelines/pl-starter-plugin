<?php
/*
	Author: PageLines
	Author URI: http://pagelines.com
	Plugin Name: PageLines Starter Plugin
	Plugin URI: http://pagelines.com
	Version: 1.0
	Description: A starter plugin for PageLines.
	Demo:
	Pagelines:true
*/

// Check to make sure a PageLines theme is active.
add_action('pagelines_setup', 'pl_plugin_init' );

// Initialize the plugin.
function pl_plugin_init() {

	if( !function_exists('pl_has_editor') )
		return;

	$landing = new pl_starter_plugin;
}
class pl_starter_plugin {

	const version = '1.2';

	function __construct() {

		$this->id   = 'pl_plugin';
		$this->name = 'PageLines Starter Plugin';
        $this->dir  = plugin_dir_path( __FILE__ );
        $this->url  = plugins_url( '', __FILE__ );
        // $this->icon = plugins_url( '/icon.png', __FILE__ );

		add_action( 'template_redirect',  array(&$this,'insert_less' ));
		add_action( 'init', array( &$this, 'init' ) );

	}

    // Add a LESS file.
	function insert_less() {

        $file = sprintf( '%sstyle.less', plugin_dir_path( __FILE__ ) ); // In the variable $file add the url for the style.less file.
        if(function_exists('pagelines_insert_core_less')) {
            pagelines_insert_core_less( $file );
        }

    }

	function init(){ // Initialize the plugin.

		add_action( 'wp_enqueue_scripts', array(&$this,'scripts' )); 
		add_filter('pl_settings_array', array(&$this, 'options')); 
	}

    // Enqueue scripts.
	function scripts(){

		wp_register_script('pl_plugin-script',$this->url.'/script.js', array('jquery'), self::version, true );

		//wp_enqueue_script('pl_plugin-script');
	}

    // Init options
    // Choose from Font Awesome icons for Icon
    // Position denotes how far from the top in Site Settings Tab
    function options( $settings ){

        $settings[ $this->id ] = array(
                'name'  => $this->name,
                'icon'  => 'icon-dashboard',
                'pos'   => 5,
                'opts'  => $this->global_opts()
        );

        return $settings;
    }

    // Draw Options Panel
    // Call settings as $var = pl_setting($this->id.'_optionB');
    function global_opts(){

        $global_opts = array(
            array(
                'key' => $this->id.'_optionA',
                'type' => 'multi',
                'title' => __('Sample Option', 'pl-plugin'),
                'opts' => array(
                    array(
                        'key' => $this->id.'_optionB',
                        'type' => 'text',
                        'label' => __('Some Option', 'pl-plugin'),
                    ),
                    array(
                        'key' => $this->id.'_optionC',
                        'type' => 'text',
                        'label' => __('Some Option', 'pl-plugin'),
                    ),
                ),
            ),

        );

        return $global_opts;
    }

}


