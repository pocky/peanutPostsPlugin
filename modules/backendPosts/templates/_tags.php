<?php use_helper('JavascriptBase', 'Tags')  ?>
<?php  
  // much of this I copied and adapted from a cached admin generator template.
  $name = 'new_tags'; $label = ''; $help = ''; 
  $class = 'sf_admin_form_row sf_admin_text sf_admin_form_field_tags';
?>
 
  <div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderError() ?>
    <div>
      <?php echo $form[$name]->renderLabel($label) ?>
 
      <div class="content"><?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
 
 
<?php // tag cloud will go here, see below ?>
 
 
</div>
 
      <?php if($help): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php elseif ($help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo $help ?></div>
      <?php endif; ?>
    </div>
  </div>
 
<?php // list of current tags, with remove buttons ?>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_tags">
  
  <div>
  <label>Current tags</label>
    <div class="content">
      <div class="taglist">   
      <?php foreach($form->getObject()->getTags() as $t) { ?>
      <span><nobr><?php 
      
        echo link_to_function("Remove '$t'", 
        "remove_tag('".$form->getName()."',".json_encode($t).", this.parentElement)", 
        "class=removetag")
      
      ?>&nbsp;<?php echo $t ?></nobr></span>
      <?php } ?>
      </div>
      
    <span id="remove_tag_help" style="display:none;">Tag(s) removed. Remember to save the complaint.</span>
    
    </div>
  </div>
 
</div>

<script type="text/javascript">
$(function() {
  function split(val) {
  	return val.split(/\s*,\s*/);
  }
  function extractLast(term) {
          last = split(term).pop();
  	return last;
  }
  
  
  $("#new_tags").autocomplete({
  
  	source: function(request, response) {
        $.getJSON(<?php echo json_encode(url_for("taggableComplete/complete")) ?>, {
  			current: extractLast(request.term)
  		}, response);
  	},
  	search: function() {
  		// custom minLength
  		var term = extractLast(this.value);
  		if (term.length < 1) {
  			return false;
  		}
  	},
          focus: function(event, ui) {
  		// prevent value inserted on focus
  		return false;
  	},
  	select: function(event, ui) {
  		var terms = split( this.value );
  		// remove the current input
  		terms.pop();
  		// add the selected item
  		terms.push( ui.item.value );
  		// add placeholder to get the comma-and-space at the end
  		terms.push("");
  		this.value = terms.join(", ");
  		return false;
  	}
  
  });
});
</script>