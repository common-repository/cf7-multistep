<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
class ctf_7_multistep_backend{
    function __construct(){
        if(!isset($_GET["builder"])):
            add_action("admin_enqueue_scripts",array($this,"add_lib"),0,0);
            add_filter("wpcf7_editor_panels",array($this,"custom_form"));
            //add_action("wpcf7_save_contact_form", array($this,"save_data"));
            add_action("save_post", array($this,"save_data"));
            add_filter( "cf7_multistep_remove_key", array($this,"remove_key_number") );
        endif;
    }
    function remove_key_number($key) {
        return preg_replace("#(-[0-9]*)$#","",$key);
    }
    function save_data($post_id){
        $names = @$_POST["cf7_steps_name"];
        $data = @$_POST["cf7_steps_value"];
        if( is_array($names)) {
            array_push($names,"check");
            array_push($data,"[text* multistep]");
        }
        add_post_meta($post_id, '_cf7_multistep_name', $names,true) or update_post_meta($post_id, '_cf7_multistep_name', $names);
        add_post_meta($post_id, '_cf7_multistep', $data,true) or update_post_meta($post_id, '_cf7_multistep', $data);

        $type = @$_POST["cf7_multistep_type"];
        add_post_meta($post_id, '_cf7_multistep_type', $type,true) or update_post_meta($post_id, '_cf7_multistep_type', $type);
        $multistep_cf7_steps_next = @$_POST["multistep_cf7_steps_next"];
        add_post_meta($post_id, 'multistep_cf7_steps_next', $multistep_cf7_steps_next,true) or update_post_meta($post_id, 'multistep_cf7_steps_next', $multistep_cf7_steps_next);
        //die($multistep_cf7_steps_next);
        $multistep_cf7_steps_prev = @$_POST["multistep_cf7_steps_prev"];
        add_post_meta($post_id, 'multistep_cf7_steps_prev', $multistep_cf7_steps_prev,true) or update_post_meta($post_id, 'multistep_cf7_steps_prev', $multistep_cf7_steps_prev);
        $multistep_cf7_steps_background = @$_POST["multistep_cf7_steps_background"];
        add_post_meta($post_id, 'multistep_cf7_steps_background', $multistep_cf7_steps_background,true) or update_post_meta($post_id, 'multistep_cf7_steps_background', $multistep_cf7_steps_background);
        $multistep_cf7_steps_color = @$_POST["multistep_cf7_steps_color"];
        add_post_meta($post_id, 'multistep_cf7_steps_color', $multistep_cf7_steps_color,true) or update_post_meta($post_id, 'multistep_cf7_steps_color', $multistep_cf7_steps_color);
        $multistep_cf7_steps_inactive_background = @$_POST["multistep_cf7_steps_inactive_background"];
        add_post_meta($post_id, 'multistep_cf7_steps_inactive_background', $multistep_cf7_steps_inactive_background,true) or update_post_meta($post_id, 'multistep_cf7_steps_inactive_background', $multistep_cf7_steps_inactive_background);
        $multistep_cf7t_steps_inactive = @$_POST["multistep_cf7t_steps_inactive"];
        add_post_meta($post_id, 'multistep_cf7t_steps_inactive', $multistep_cf7t_steps_inactive,true) or update_post_meta($post_id, 'multistep_cf7t_steps_inactive', $multistep_cf7t_steps_inactive);
        $multistep_cf7t_steps_completed_backgound = @$_POST["multistep_cf7t_steps_completed_backgound"];
        add_post_meta($post_id, 'multistep_cf7t_steps_completed_backgound', $multistep_cf7t_steps_completed_backgound,true) or update_post_meta($post_id, 'multistep_cf7t_steps_completed_backgound', $multistep_cf7t_steps_completed_backgound);
        $multistep_cf7_steps_completed = @$_POST["multistep_cf7_steps_completed"];
        add_post_meta($post_id, 'multistep_cf7_steps_completed', $multistep_cf7_steps_completed,true) or update_post_meta($post_id, 'multistep_cf7_steps_completed', $multistep_cf7_steps_completed);
        $multistep_cf7_steps_first = @$_POST["multistep_cf7_steps_first"];
        add_post_meta($post_id, 'multistep_cf7_steps_first', $multistep_cf7_steps_first,true) or update_post_meta($post_id, 'multistep_cf7_steps_first', $multistep_cf7_steps_first);
        $data = @$_POST["multistep_cf7_steps_data"];
        add_post_meta($post_id, '_multistep_cf7_steps_data', $data,true) or update_post_meta($post_id, '_multistep_cf7_steps_data', $data);
    }
    function add_lib(){
        wp_enqueue_script("cf7_multistep",CT_7_MULTISTEP_PLUGIN_URL."/backend/js/cf7-multistep.js",array("wp-color-picker"),time());
        wp_enqueue_style("cf7_multistep",CT_7_MULTISTEP_PLUGIN_URL."/backend/css/cf7-multistep.css",array("wp-color-picker"),time());
        wp_localize_script("cf7_multistep","cf7_step",array("html_form"=>cf7_get_get_data_html(),"form"=>cf7_setp_get_form_html(),"html_settings"=>cf7_step_get_settings_html()));
    }
    function custom_form($panels){
        if(isset($_GET["builder_tab"]) && $_GET["builder_tab"] == "design"){
        }else{
            $panels["form-panel"] = array(
                'title' => __( 'Form', 'contact-form-7' ),
                'callback' => "wpcf7_editor_panel_form_custom" );
        }
        $panels["form-panel-multistep-setting"] = array(
                'title' => __( 'Settings Multistep', 'contact-form-7' ),
                'callback' => "cf7_multistep_setting_form" );
        return $panels;
    }
}
new ctf_7_multistep_backend;
function cf7_multistep_setting_form($post){
    $post_id = $post->id();
    $settings = cf7_multistep_get_setttings_stype($post_id);
    ?>
     <table class="form-table">
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    <?php _e("Next Button",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input name="multistep_cf7_steps_next" type="text" value="<?php echo $settings["multistep_cf7_steps_next"] ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_prev">
                    <?php _e("Previous Button",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input name="multistep_cf7_steps_prev" type="text" value="<?php echo $settings["multistep_cf7_steps_prev"] ?>" class="regular-text">
            </td>
        </tr>
         <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_first">
                    <?php _e("First Button",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input name="multistep_cf7_steps_first" type="text" value="<?php echo $settings["multistep_cf7_steps_first"] ?>" class="regular-text">
            </td>
        </tr>
         <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_background">
                    <?php _e("Steps background",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7_steps_background" class="color" value="<?php echo $settings["multistep_cf7_steps_background"] ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_color">
                    <?php _e("Steps color",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7_steps_color" class="color" value="<?php echo $settings["multistep_cf7_steps_color"] ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_inactive_background">
                    <?php _e("Background for inactive steps",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7_steps_inactive_background" class="color" value="<?php echo $settings["multistep_cf7_steps_inactive_background"] ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7t_steps_inactive">
                    <?php _e("Color for inactive steps",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7t_steps_inactive" class="color" value="<?php echo $settings["multistep_cf7t_steps_inactive"] ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7t_steps_completed_backgound">
                    <?php _e("Completed steps background",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7t_steps_completed_backgound" class="color" value="<?php echo $settings["multistep_cf7t_steps_completed_backgound"] ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_completed">
                    <?php _e("Completed steps color",'contact-form-7-multistep-pro') ?>
                </label>
            </th>
            <td>
                <input type="text" name="multistep_cf7_steps_completed" class="color" value="<?php echo $settings["multistep_cf7_steps_completed"] ?>" />
            </td>
        </tr>
    </table>
    <h3><?php _e("Labels Step Confirm",'contact-form-7-multistep-pro') ?></h3>
    <table class="form-table data-setting-step-cf7">
        <?php 
        $tags = $post->scan_form_tags();
        $data = cf7_multistep_get_data_confirm($post_id);
        foreach ($tags as $tag):
        if ($tag['type'] == 'group' || $tag['type'] == 'acceptance' || $tag['name'] == '') continue;
        if( isset($data[$tag['name']])){
            $name = $data[$tag['name']];
        }else{
            $name = "";
        }     
         ?>
        <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    <?php echo $tag['name'];?>
                </label>
            </th>
            <td>
                <input name="multistep_cf7_steps_data[<?php echo $tag['name'] ?>]" type="text" value="<?php echo esc_attr($name) ?>" class="regular-text">
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php
}
function cf7_multistep_get_data_confirm($post_id){
    return get_post_meta($post_id,"_multistep_cf7_steps_data",true);
}
function cf7_multistep_get_setttings($post_id = null, $last = null){
    if( $post_id ){
        $data_steps_name = get_post_meta($post_id,"_cf7_multistep_name",true);
        //var_dump( $data_steps_name );
        $data_steps_value = get_post_meta($post_id,"_cf7_multistep",true);
       // var_dump( $data_steps_value );
        $data_steps = array();
        $i = 0;
        if( is_array($data_steps_name)) {
            foreach( $data_steps_name as $value ) {
                if( $value == "check" ) {
                    $data_steps[$value] = $data_steps_value[$i];
                }else{
                    $data_steps[$value."-".$i] = $data_steps_value[$i];
                }
                $i++;
            }
        }else{
             return array(
                "step 1" => "<label> Your Name (required)
    [text* your-name] </label>
",
                "step 2" => "
<label> Your Email (required)
    [email* your-email] </label>
<label> Subject
    [text your-subject] </label>
<label> Your Message
    [textarea your-message] </label>
[submit \"Send\"]",
        );
        }
    }
    if( is_array(@$data_steps)) {
        if(!$last) {
            unset($data_steps["check"]);
        }
        return $data_steps;
    }else{
        return array(
                "step 1" => "<label> Your Name (required)
    [text* your-name] </label>
",
                "step 2" => "
<label> Your Email (required)
    [email* your-email] </label>
<label> Subject
    [text your-subject] </label>
<label> Your Message
    [textarea your-message] </label>
[submit \"Send\"]",
        );
    }
}
/*
* Cover keyword " to |
*/
function cf7_cover_keyword($data){
    return preg_replace('#"#',"|",$data);
}
function cf7_multistep_get_setttings_stype($post_id){
    $multistep_cf7_steps_first = (get_post_meta($post_id,"multistep_cf7_steps_first",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_first",true): "First";
    $multistep_cf7_steps_next = (get_post_meta($post_id,"multistep_cf7_steps_next",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_next",true): "Next";
    $multistep_cf7_steps_prev = (get_post_meta($post_id,"multistep_cf7_steps_prev",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_prev",true): "Previous";
    $multistep_cf7_steps_background = (get_post_meta($post_id,"multistep_cf7_steps_background",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_background",true): "#B6D7EA";
    $multistep_cf7_steps_color = (get_post_meta($post_id,"multistep_cf7_steps_color",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_color",true): "#666";
    $multistep_cf7_steps_inactive_background = (get_post_meta($post_id,"multistep_cf7_steps_inactive_background",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_inactive_background",true): "#5fc562";
    $multistep_cf7t_steps_inactive = (get_post_meta($post_id,"multistep_cf7t_steps_inactive",true) ) ? get_post_meta($post_id,"multistep_cf7t_steps_inactive",true): "#fff";
    $multistep_cf7t_steps_completed_backgound = (get_post_meta($post_id,"multistep_cf7t_steps_completed_backgound",true) ) ? get_post_meta($post_id,"multistep_cf7t_steps_completed_backgound",true): "#3491C4";
    $multistep_cf7_steps_completed = (get_post_meta($post_id,"multistep_cf7_steps_completed",true) ) ? get_post_meta($post_id,"multistep_cf7_steps_completed",true): "#fff";
  return array(
            "multistep_cf7_steps_next"=>$multistep_cf7_steps_next,
            "multistep_cf7_steps_prev" =>$multistep_cf7_steps_prev,
            "multistep_cf7_steps_background"=>$multistep_cf7_steps_background,
            "multistep_cf7_steps_color"=>$multistep_cf7_steps_color,
            "multistep_cf7_steps_inactive_background"=>$multistep_cf7_steps_inactive_background,
            "multistep_cf7t_steps_inactive"=>$multistep_cf7t_steps_inactive,
            "multistep_cf7t_steps_completed_backgound"=>$multistep_cf7t_steps_completed_backgound,
            "multistep_cf7_steps_completed"=>$multistep_cf7_steps_completed,
            "multistep_cf7_steps_first" => $multistep_cf7_steps_first
            );
}
function wpcf7_editor_panel_form_custom($post){
    $post_id = $post->id();
 ?>
        <h2><?php echo esc_html( __( 'Form', 'contact-form-7' ) ); ?></h2>
        <?php
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->print_buttons();
            $type = get_post_meta($post_id,"_cf7_multistep_type",true);
        ?>
            <div class="cf7-multistep-header-container">
                <label><strong><?php _e("Enable Multistep",'contact-form-7-multistep-pro') ?></strong>: </label>
                <?php 
                    $check_purchase_code = get_option("_redmuber_item_19635969");
                    if( $check_purchase_code == "ok" ):
                ?>
                <select name="cf7_multistep_type" class="cf7_multistep_type">
                    <option value="0"><?php _e("Nothing",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(1,$type) ?> value="1"><?php _e("Style 1",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(2,$type) ?> value="2"><?php _e("Style 2",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(3,$type) ?> value="3"><?php _e("Style 3",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(4,$type) ?> value="4"><?php _e("Style 4",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(5,$type) ?> value="5"><?php _e("Style 5",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(6,$type) ?> value="6"><?php _e("Style 6",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(7,$type) ?> value="7"><?php _e("Style 7",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(8,$type) ?> value="8"><?php _e("Style 8",'contact-form-7-multistep-pro') ?></option>
                    <option <?php selected(99,$type) ?> value="99"><?php _e("Hide Style",'contact-form-7-multistep-pro') ?></option>
                </select>
                <?php 
                else:
                    echo "<p>".esc_html__("Please enter puschase code","contact-form-7-multistep-pro").": <a href='".admin_url("plugins.php") ."'>".admin_url("plugins.php") ."</a></p>";
                endif
                 ?>
                <?php if ( is_plugin_active( 'contact-form-7-builder-designer/index.php' )  ) { ?>
                <a href="<?php echo add_query_arg("builder_tab","design"); ?>">Use Form Builder </a>
                <?php } ?>
            </div>
        <div class="container-step-cf7 <?php if( $type ==0 || $type == ""){echo "hidden";} ?>">
            <div class="ctf-7-tab-steps">
                <ul>
                    <?php
                    $i=0;
                    $settings = cf7_multistep_get_setttings($post_id);
                    foreach( $settings as $key => $value ):
                     ?>
                    <li class="cf7-step-head-tab-<?php echo $i ?>"><a data-tab=".cf7-tab-step-<?php echo $i ?>" class="cf7-step <?php if( $i==0){echo "active";}; echo " cf7_steps_name-{$i}" ?>" href="#"><?php echo apply_filters("cf7_multistep_remove_key",$key) ?></a></li>
                    <?php
                    $i++;
                    endforeach; ?>
                    <li><a class="cf7-add-step" href="#"><i class="controls-icon-plus"></i></a></li>
                </ul>
            </div>
            <div class="cf7-container-step">
                <?php
                $i=0;
                foreach( $settings  as $key => $value) : ?>
                <div class="cf7-tab-step cf7-tab-step-<?php echo $i;if($i !=0){echo " hidden";} ?>">
                    <div class="cf7-header-step">
                        <label>Name</label>
                        <input name="cf7_steps_name[]" data-tab=".cf7_steps_name-<?php echo $i ?>" title="text" class="regular-text cf7_steps_name"  value="<?php echo apply_filters("cf7_multistep_remove_key",$key) ?>"/>
                        <a data-id="<?php echo $i ?>" class="button cf7_remove_step" href="#">Remove</a>
                    </div>
                    <div class="cf7-body-step">
                    <textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body"><?php echo apply_filters("cf7_multistep",$value) ?></textarea>
                    </div>
                </div>
                <?php
                $i++;
                endforeach; ?>
                <input id="cf7_tab_count" value="<?php echo $i ?>" type="hidden" />
            </div>
        </div>
        <textarea id="wpcf7-form" name="wpcf7-form" cols="100" rows="24" class="large-text code <?php if( $type !=0 && $type != ""){echo "hidden";} ?>" data-config-field="form.body"><?php echo esc_textarea( $post->prop( 'form' ) ); ?></textarea>
        <?php
}