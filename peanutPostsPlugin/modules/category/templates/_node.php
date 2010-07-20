<li><a href="<?php echo url_for('post_category', array('categoryName' => $node->getSlug(), 'sf_format' => 'html')) ?>" title="<?php echo $node->getName() ?>"><?php echo $node->getName() ?></a>
  
  <?php
    if($node->getNode()->hasChildren()):
      $children = $node->getNode()->getChildren(); ?>
      
      <ul>
      <?php
        foreach($children as $child):
          include_partial('category/node', array('node' => $child));
        endforeach;
      ?>
      </ul>
    <?php endif;
  ?>
</li>