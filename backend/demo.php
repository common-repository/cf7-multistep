<?php
if( ! class_exists( "cf7_import_demo" ) ) {
	class cf7_import_demo{
		function __construct(){
			add_filter("wpcf7_editor_panels",array($this,"custom_form"));
		}
		function custom_form($panels){
			$panels["form-panel-import-demo"] = array(
					'title' => __( 'Import Demo', 'contact-form-7' ),
					'callback' => array($this,"page" ));

			return $panels;
		}
		function page($post){
			$content ='<table class="form-table">';
			echo apply_filters("contact_form_7_import",$content,$post);
			echo '</table>';
		}
	}
	new cf7_import_demo();
}
add_filter("contact_form_7_import","contact_form_7_import_multistep_logic");
function contact_form_7_import_multistep_logic($content){
	$new_content ='<tr>
					<th scope="row">
						<label for="">
							Multi-Step Pro Plugin
						</label>
					</th>
					<td>
						<a class="button cf7_import_demo_multistep" href="#">Click import content demo</a>
					</td>
				</tr>';
	return $content . $new_content;
}
function cf7_get_get_data_html(){
	return '<div class="ctf-7-tab-steps">
                <ul>
                                        <li class="cf7-step-head-tab-0"><a data-tab=".cf7-tab-step-0" class="cf7-step active cf7_steps_name-0" href="#">Account</a></li>
                                        <li class="cf7-step-head-tab-1"><a data-tab=".cf7-tab-step-1" class="cf7-step  cf7_steps_name-1" href="#">Personal</a></li>
                                        <li class="cf7-step-head-tab-2"><a data-tab=".cf7-tab-step-2" class="cf7-step  cf7_steps_name-2" href="#">Contact</a></li>
                                        <li class="cf7-step-head-tab-3"><a data-tab=".cf7-tab-step-3" class="cf7-step  cf7_steps_name-3" href="#">Confirm</a></li>
                                        <li><a class="cf7-add-step" href="#"><i class="controls-icon-plus"></i></a></li>
                </ul>

            </div>
                        <div class="cf7-container-step">
                                <div class="cf7-tab-step cf7-tab-step-0">
                    <div class="cf7-header-step">
                        <label>Name</label>
                        <input name="cf7_steps_name[]" data-tab=".cf7_steps_name-0" title="text" class="regular-text cf7_steps_name"  value="Account"/>
                        <a data-id="0" class="button cf7_remove_step" href="#">Remove</a>
                    </div>
                    <div class="cf7-body-step">
                    <textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body"><label> Your Name
[text your-name] </label>
<label> Your Email (required)
[email* your-email] </label></textarea>
                    </div>
                </div>
                                <div class="cf7-tab-step cf7-tab-step-1 hidden">
                    <div class="cf7-header-step">
                        <label>Name</label>
                        <input name="cf7_steps_name[]" data-tab=".cf7_steps_name-1" title="text" class="regular-text cf7_steps_name"  value="Personal"/>
                        <a data-id="1" class="button cf7_remove_step" href="#">Remove</a>
                    </div>
                    <div class="cf7-body-step">
                    <textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body"><label> What is your phone number? (required)
[text* phone] </label>
<label> Address
[text address] 
</label></textarea>
                    </div>
                </div>
                                <div class="cf7-tab-step cf7-tab-step-2 hidden">
                    <div class="cf7-header-step">
                        <label>Name</label>
                        <input name="cf7_steps_name[]" data-tab=".cf7_steps_name-2" title="text" class="regular-text cf7_steps_name"  value="Contact"/>
                        <a data-id="2" class="button cf7_remove_step" href="#">Remove</a>
                    </div>
                    <div class="cf7-body-step">
                    <textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body"><label> Would you like to receive our free catalog via postal mail?
   [radio radio-845 default:1 "Yes" "No"] </label>
<label> Which kind of communication do you prefer?
   [checkbox checkbox-797 "Phone" "Email"] </label></textarea>
                    </div>
                </div>
                                <div class="cf7-tab-step cf7-tab-step-3 hidden">
                    <div class="cf7-header-step">
                        <label>Name</label>
                        <input name="cf7_steps_name[]" data-tab=".cf7_steps_name-3" title="text" class="regular-text cf7_steps_name"  value="Confirm"/>
                        <a data-id="3" class="button cf7_remove_step" href="#">Remove</a>
                    </div>
                    <div class="cf7-body-step">
                    <textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body">[step_confirm]
[acceptance acceptance-211]I agree to the terms of service.
[submit]</textarea>
                    </div>
                </div>
                                <input id="cf7_tab_count" value="4" type="hidden" />
            </div>
        ';
}

function cf7_setp_get_form_html(){
	return '<label> Your Name
[text your-name] </label>
<label> Your Email (required)
[email* your-email] </label>
<label> What is your phone number? (required)
[text* phone] </label>
<label> Address
[text address] 
</label>
<label> Would you like to receive our free catalog via postal mail?
   [radio radio-845 default:1 "Yes" "No"] </label>
<label> Which kind of communication do you prefer?
   [checkbox checkbox-797 "Phone" "Email"] </label>
[step_confirm]
[acceptance acceptance-211]I agree to the terms of service.
[submit]';
}
function cf7_step_get_settings_html(){
	return '<tbody><tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    your-name                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[your-name]" type="text" value="Your Name" class="regular-text">
            </td>
        </tr>
            <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    your-email                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[your-email]" type="text" value="Your Email" class="regular-text">
            </td>
        </tr>
            <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    phone                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[phone]" type="text" value="Phone" class="regular-text">
            </td>
        </tr>
            <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    address                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[address]" type="text" value="Address" class="regular-text">
            </td>
        </tr>
            <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    radio-845                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[radio-845]" type="text" value="Would you like to receive our free catalog via postal mail?" class="regular-text">
            </td>
        </tr>
            <tr>
            <th scope="row">
                <label for="multistep_cf7_steps_next">
                    checkbox-797                </label>
            </th>
            <td>

                <input name="multistep_cf7_steps_data[checkbox-797]" type="text" value="Which kind of communication do you prefer?" class="regular-text">
            </td>
        </tr>
        </tbody>';
}