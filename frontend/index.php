<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
class cf7_multistep_frontend {
    function __construct(){
        add_filter('get_post_metadata', array($this,'getqtlangcustomfieldvalue'), 10, 4);
        add_action("wp_enqueue_scripts",array($this,"add_lib"),1000);
        //add_filter("wpcf7_additional_mail",array($this,"block_send_email"),10,2);
        //add_filter("wpcf7_validate",array($this,"wpcf7_validate"));
    }
    /*
    * Block send email
    */
    function block_send_email($email,$contact_form){
        if( isset( $_POST["_wpcf7_check_tab"] )) {
            $tabs = count ( cf7_multistep_get_setttings($contact_form->id) -1 );
            if( $tabs != $_POST["_wpcf7_check_tab"] ) {
                return true;
            }
        }
    }
    function wpcf7_validate($result){
        $result->invalidate("step","ok");
        return $result;
    }
    /*
    * Add js and css
    */
    function add_lib(){
        wp_enqueue_script("cf7_multistep",CT_7_MULTISTEP_PLUGIN_URL."frontend/js/cf7-multistep.js",array("jquery"),time());
        $uploads = wp_upload_dir();
        $upload_path = $uploads['baseurl'].'/cf7-uploads-custom/';
        wp_localize_script( 'cf7_multistep', 'cf7_multistep',
        array( 
            'img_url' => $upload_path,
        )
    );
        wp_enqueue_style("cf7_multistep",CT_7_MULTISTEP_PLUGIN_URL."frontend/css/cf7-multistep.css",array(),time());
    }
    /*
    * Custom steps
    */
    function getqtlangcustomfieldvalue($value, $post_id, $meta_key, $single) {
        if( !is_admin() ):
            if( $meta_key == "_form" ){
                $type = get_post_meta( $post_id,"_cf7_multistep_type",true);
                if( $type != 0 && $type){
                    $tabs = cf7_multistep_get_setttings($post_id,true);
                    $last_form = $tabs["check"];
                    unset($tabs["check"]);
                    $count_tab = count($tabs);
                    $settings =  cf7_multistep_get_setttings_stype($post_id);
                    $class = "";
                    if( $type == 5 || $type == 6 || $type == 7 || $type == 8) {
                        $class = "cf7-display-steps-container cf7-display-steps-container-5";
                    }else{
                        $class = "cf7-display-steps-container cf7-display-steps-container-".$type;
                    }
                    $id_form = "cf7-form-step-id-{$post_id}";
                    ob_start();
                    ?>
                    <div class="hidden multistep-check">
                    <?php echo $last_form; ?>
                    </div>
                    <div class="hidden">
                         <input name="_wpcf7_check_tab" value="1" class="wpcf7_check_tab" type="hidden" />
                        <input class="multistep_total" value="<?php echo $count_tab  ?>" type="hidden" />
                    </div><!-- /.hidden -->
                    <div class="container-cf7-steps container-cf7-steps-<?php echo $type ?>" id="<?php echo $id_form  ?>">
                        <div class="container-multistep-header <?php  if( $type == 99 ) {echo "hidden";}?>">
                            <ul class="<?php echo $class ?>">
                                    <?php
                                    $i=1;
                                    foreach( $tabs as $key=>$value):
                                        switch ($type) {
                                            case 5:
                                            case 6:
                                                $before_content =$i;
                                                break;
                                            case 7:
                                            case 8:
                                                if( $i > 1) {
                                                    $before_content = "X";
                                                }else{
                                                    $before_content = "✓";
                                                }
                                                break;
                                            default:
                                                $before_content ="";
                                                break;
                                        }
                                    ?>
                                     <li  class='<?php if( $i== 1){echo "active"; $key_active = $key; } ?> cf7-steps-<?php echo $i ?>' data-i="<?php echo $i ?>" data-tab=".cf7-tab-<?php echo $i ?>"><span class='before'><?php echo $before_content ?></span><span class='cf-content-s'><?php echo apply_filters("cf7_multistep_remove_key",$key) ?></span><span class='after'></span></li>  
                                    <?php
                                    $i++;
                                     endforeach; ?>
                            </ul>
                        </div>
                        <div class="container-body-tab"><?php $i=1;foreach( $tabs as $key=>$value):?><div class="cf7-tab <?php if( $i!= 1){ echo "hidden";} ?> cf7-tab-<?php  echo esc_attr($i) ?>" ><div class="cf7-content-tab"><?php echo apply_filters("cf7_multistep",$value) ?></div><div class="multistep-nav"><div class="multistep-nav-left"><?php  if( $i!=1): ?><a href="#" class="multistep-cf7-first"><?php _e($settings["multistep_cf7_steps_first"],'contact-form-7-multistep-pro');  ?></a><a href="#" class="multistep-cf7-prev"><?php _e($settings["multistep_cf7_steps_prev"],'contact-form-7-multistep-pro');  ?></a><?php endif; ?></div><div class="multistep-nav-right"><?php if( $count_tab != $i ): ?><span class="wpcf7-spinner"></span><a  href="#" class="multistep-cf7-next"><?php _e($settings["multistep_cf7_steps_next"],'contact-form-7-multistep-pro');  ?></a><?php endif; ?></div></div></div><?php $i++; endforeach; ?>
                        </div></div>
                    <style type="text/css">
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li span.before,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li span.after{
                            background-color: <?php echo $settings["multistep_cf7_steps_background"] ?> !important;
                            color: <?php echo $settings["multistep_cf7_steps_color"] ?> !important;
                        }
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li.active,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li.active,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li.active,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li.active,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.active span.before{
                            background: <?php echo $settings["multistep_cf7_steps_inactive_background"] ?> !important;
                            color: <?php echo $settings["multistep_cf7t_steps_inactive"] ?> !important;
                        }
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li span.after{
                            border-left: 16px solid <?php echo $settings["multistep_cf7_steps_background"] ?> !important;
                         }
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li.active .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li.active .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li.active .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li.active .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.active span.after{
                            border-left: 16px solid <?php echo $settings["multistep_cf7_steps_inactive_background"] ?> !important;
                        }
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li.enabled .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li.enabled .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li.enabled .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li.enabled .after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.enabled span.after{
                            border-left: 16px solid <?php echo $settings["multistep_cf7t_steps_completed_backgound"] ?> !important;
                        }
                        #<?php echo $id_form  ?> .cf7-display-steps-container-1 li.enabled,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-2 li.enabled,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-3 li.enabled,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-4 li.enabled,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.enabled span.before,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.enabled span.after,
                        #<?php echo $id_form  ?> .cf7-display-steps-container-5 li.active span.after{
                            background: <?php echo $settings["multistep_cf7t_steps_completed_backgound"] ?> !important;
                            color: <?php echo $settings["multistep_cf7_steps_completed"] ?> !important;
                        }
                        #<?php echo $id_form  ?>.container-cf7-steps-7 .cf7-display-steps-container-5 li.active span.before,
                        #<?php echo $id_form  ?>.container-cf7-steps-8 .cf7-display-steps-container-5 li.active span.before{
                            box-shadow: 0 0 0 2px <?php echo $settings["multistep_cf7_steps_inactive_background"] ?> !important;
                        }
                        #<?php echo $id_form  ?> .multistep-nav a{
                            background: <?php echo $settings["multistep_cf7_steps_background"] ?> !important;
                            color: <?php echo $settings["multistep_cf7_steps_color"] ?> !important;
                            padding: 5px 15px;
                            text-decoration: none;
                        }
                    </style>
                     <script type="text/javascript">
                        var cf7_step_confirm = <?php echo json_encode( cf7_multistep_get_data_confirm($post_id) ) ?>;
                    </script>
                    <?php 
                    $value = ob_get_clean();
                    $str= @str_replace("\r\n","",$str);
                }
            }
         endif;
             return $value;
    }
}
new cf7_multistep_frontend;