<?php $sf_context->getModuleName() == "backendCategories" ? $current =  "current" : $current = null ?>

<li>
	<?php echo link_to(__('categories'), '@peanut_categories', array('class' => 'nav-top-item '.$current.'', 'title' => __('categories'))); ?>
	<ul>
		<li><?php echo link_to(__('Show categories'), '@peanut_categories'); ?></li>
		<li><?php echo link_to(__('Add new category'), '@peanut_categories_new'); ?></li>
	</ul>
</li>