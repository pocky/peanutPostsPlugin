<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($backendCategories['id'], 'backendCategories/edit', $backendCategories) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Categories">
  <span class="<?php echo $backendCategories->getNode()->isLeaf() ? 'file' : 'folder' ?>">
    <?php echo $backendCategories['name'] ?>
  </span>
</td>

