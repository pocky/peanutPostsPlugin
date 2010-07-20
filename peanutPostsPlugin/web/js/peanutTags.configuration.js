 function remove_tag (tag, element) {
  remove_field = $("#peanut_posts_remove_tags");
  if ( remove_field.val() ) {
    remove_field.val( remove_field.val()  + "," + tag );
  }
  else {
    remove_field.val( tag );
  }
  $(element).hide();
  $("#remove_tag_help").show();
}