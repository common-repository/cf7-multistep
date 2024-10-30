<?php
add_action( 'wpcf7_init', 'wpcf7_add_form_tag_step_confirm' );
function wpcf7_add_form_tag_step_confirm() {
	wpcf7_add_form_tag( array( 'step_confirm' ),
		'wpcf7_step_confirm_form_tag_handler',
		array(
			'name-attr' => true,
			'selectable-values' => true,
		)
	);
}
function wpcf7_step_confirm_form_tag_handler($tag){
	return '<div class="cf7-data-confirm"></div>';
}
/* Tag generator */
add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_step_confirm', 98 );
function wpcf7_add_tag_generator_step_confirm() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'step_confirm', __( 'Step Confirm', 'contact-form-7-multistep-pro' ),
		'wpcf7_tag_generator_step_confirm' );
}
function wpcf7_tag_generator_step_confirm( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
?>
<div class="control-box">
<fieldset>
<table class="form-table">
<tbody>
</tbody>
</table>
</fieldset>
</div>
<div class="insert-box">
	<input type="text" name="step_confirm" class="tag code" readonly="readonly" onfocus="this.select()" />
	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>
	<td><input type="hidden" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>   
	<br class="clear" />
	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>
<?php
}
