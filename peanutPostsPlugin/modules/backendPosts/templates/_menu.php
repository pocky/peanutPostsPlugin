<?php $sf_context->getModuleName() == "backendPosts" ? $current =  "current" : $current = null ?>

<li>
	<?php echo link_to(__('posts'), '@peanut_posts', array('class' => 'nav-top-item '.$current.'', 'title' => __('posts'))); ?>
	<ul>
		<li><?php echo link_to(__('Show posts'), '@peanut_posts'); ?></li>
		<li><?php echo link_to(__('Add new post'), '@peanut_posts_new'); ?></li>
	</ul>
</li>