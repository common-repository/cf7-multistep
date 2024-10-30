jQuery(document).ready(function($){

     $(".cf7_import_demo_multistep").click(function(event) {
      /* Act on the event */
      event.preventDefault();
      if (confirm('It will overwrite the current content! Do you want to do it?')) {
        $(".cf7_multistep_type").val(1).change();
         $(".container-step-cf7").html(cf7_step.html_form);
         $(".wpcf7-form").val(cf7_step.form);
         $(".data-setting-step-cf7").html(cf7_step.html_settings);
      } 
    });

    var cf7_tab_current = ".cf7-tab-step-0";
    $('.color').wpColorPicker();
    $(".cf7-add-step").click(function(e){
        var count = Math.floor(Math.random() * 10000);
        $(".ctf-7-tab-steps ul li").last().before('<li class="cf7-step-head-tab-'+count+'"><a data-tab=".cf7-tab-step-'+count+'"  class="cf7-step cf7_steps_name-'+count+'" href="#">Step</a></li>');
        /*
        * Add html
        */
        var text_add = '<div class="cf7-tab-step cf7-tab-step-'+count+' hidden">';
            text_add +=    '<div class="cf7-header-step"><label>Name</label>';
            text_add +=         '<input name="cf7_steps_name[]" data-tab=".cf7_steps_name-'+count+'" title="text" class="regular-text cf7_steps_name"  value="Step"/>';
            text_add +=         '<a class="button cf7_remove_step" data-id="'+count+'" href="#">Remove</a></div><div class="cf7-body-step">';
            text_add +=         '<textarea name="cf7_steps_value[]" cols="100" rows="24" class="large-text code wpcf7-form-1" data-config-field="form.body"></textarea>';
            text_add +=     '</div></div>';
            $(".cf7-container-step").append(text_add);
        return false;
    })
    $("body").on("click",".cf7-step",function(e){
        var tab = $(this).data("tab");
        $(".cf7-step").removeClass("active");
        $(this).addClass("active");
        $(".cf7-tab-step").addClass("hidden");
        $(tab).removeClass("hidden");
        cf7_tab_current = tab;
        return false;
    })
    $("body").on("click",".cf7_remove_step",function(){
        var id = $(this).data("id");
        $(this).closest('.cf7-tab-step').remove();
        $(".ctf-7-tab-steps .cf7-step-head-tab-"+id).remove();
        return false;
    })
    $("body").on("keyup",".cf7_steps_name",function(){
        var value = $(this).val();
        var tab = $(this).data("tab");
        $(tab).html(value);
    })
    $(".cf7_multistep_type").change(function(e){
        var id = $(this).val();
        if( id== 0 ){
            $(".container-step-cf7").addClass("hidden");
            $("#wpcf7-form").removeClass("hidden");
        }else{
            $("#wpcf7-form").addClass("hidden");
            $(".container-step-cf7").removeClass("hidden");
        }
    })
    $( 'input.insert-tag' ).click( function() {
		var $form = $( this ).closest( 'form.tag-generator-panel' );
		var tag = $form.find( 'input.tag' ).val();
        console.log(cf7_tab_current);
        insertAtCursor($(cf7_tab_current+" textarea"),tag);
		tb_remove(); // close thickbox
		return false;
	} );
    $("body").on("change",".cf7-container-step textarea",function(e){
        var vl = "";
        $( ".cf7-container-step textarea" ).each(function( index ) { 
            vl +=  $(this).val() + "\n";
        })
        $("#wpcf7-form").val(vl);
    })
})
function insertAtCursor(el, newText) {
    var start = el.prop("selectionStart")
      var end = el.prop("selectionEnd")
      var text = el.val()
      var before = text.substring(0, start)
      var after  = text.substring(end, text.length)
      el.val(before + newText + after)
      el[0].selectionStart = el[0].selectionEnd = start + newText.length
      el.focus()
  return false
}