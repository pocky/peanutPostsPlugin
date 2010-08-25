 $(document).ready(function(){
   $(".taglist a").button({icons:{primary:'ui-icon-trash'}, text: false});
 });
 
 function remove_tag (form, tag, element) {
  remove_field = $("#" + form + "_remove_tags");
  if ( remove_field.val() ) {
    remove_field.val( remove_field.val()  + "," + tag );
  }
  else {
    remove_field.val( tag );
  }
  $(element).hide();
  $("#remove_tag_help").show();
}