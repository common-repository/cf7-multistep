<?php
/*
Plugin Name: Contact form 7 Multi-Step – Preview Submission
Plugin URI: https://add-ons.org/plugin/contact-form-7-multi-step-pro-preview-submission/
Requires Plugins: contact-form-7
Description: Plugins help provides step by step UI for your long forms with (too) many fields.
Author: add-ons.org
Version: 6.6.4
Author URI: https://add-ons.org/
*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
define( 'CT_7_MULTISTEP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CT_7_MULTISTEP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPCF7_MULTI_VERSION', '6.3' );
include_once(ABSPATH.'wp-admin/includes/plugin.php');

/*
* Check plugin contact form 7
*/
class cf7_multistep_checkout_init {
    function __construct(){
        include CT_7_MULTISTEP_PLUGIN_PATH."backend/index.php";
        include CT_7_MULTISTEP_PLUGIN_PATH."backend/demo.php";
        include CT_7_MULTISTEP_PLUGIN_PATH."backend/confirm.php";
        include CT_7_MULTISTEP_PLUGIN_PATH."frontend/index.php";
        include CT_7_MULTISTEP_PLUGIN_PATH."superaddons/check_purchase_code.php";
        new Superaddons_Check_Purchase_Code( 
            array("plugin" => "cf7-multistep/index.php",
                    "id"=>"19635969",
                    "pro"=>"https://add-ons.org/plugin/contact-form-7-multi-step-pro-preview-submission/",
                    "plugin_name"=> "Contact Form 7 Multi-step Pro",
                    "document"=> "https://add-ons.org/document-contact-form-7-multi-step-pro-preview-submission/",
                )
        );
    }
}
new cf7_multistep_checkout_init;
if(!class_exists('Superaddons_List_Addons')) {  
    include CT_7_MULTISTEP_PLUGIN_PATH."add-ons.php"; 
}