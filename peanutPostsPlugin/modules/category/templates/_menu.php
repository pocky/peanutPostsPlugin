<li class="uppercase floatLeft"><a href="<?php echo url_for('post_index', array('sf_format' => 'html')) ?>">Peanut Posts</a>
  <ul>
    <?php
      foreach($roots as $root):
        include_partial('category/node', array('node' => $root));
      endforeach;
     ?>
  </ul>
</li>