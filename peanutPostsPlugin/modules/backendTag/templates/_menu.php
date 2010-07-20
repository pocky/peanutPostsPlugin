<?php $sf_context->getModuleName() == "backendTag" ? $current =  "current" : $current = null ?>

<li>
	<?php echo link_to(__('tags'), '@tag', array('class' => 'nav-top-item '.$current.'', 'title' => __('tags'))); ?>
	<ul>
		<li><?php echo link_to(__('Show tags'), '@tag'); ?></li>
		<li><?php echo link_to(__('Add new tag'), '@tag_new'); ?></li>
	</ul>
</li>