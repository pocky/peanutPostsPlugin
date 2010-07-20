<?php use_helper('Date') ?>
<?php slot('title', sprintf('Voir tous les articles de ', $sf_request->getParameter('sfGuardUsername'))); ?>

<?php foreach($entries as $entry) { ?>

  <div id="post-<?php echo $entry->getSlug() ?>" class="post hentry">
    <h2 class="helvetica title light"><a href="<?php echo url_for('post_show', array('categoryName' => $entry->getPeanutCategories()->getSlug(), 'slug' => $entry->getSlug(), 'sf_format' => 'html')) ?>" title="Liens vers <?php echo $entry->getTitle() ?>"><?php echo $entry->getTitle() ?></a></h2>
    
    <p>Publié le <?php echo format_date($entry->getCreatedAt(), 'dd MMMM yyyy', 'fr'); ?> à <?php echo format_date($entry->getCreatedAt(), 'HH:mm:ss', 'fr'); ?> dans la catégorie <a href="<?php echo url_for('post_category', array('categoryName' => $entry->getPeanutCategories()->getSlug(), 'sf_format' => 'html')) ?>" title="voir les articles de la catégorie <?php echo $entry->getPeanutCategories()->getName() ?>"><?php echo $entry->getPeanutCategories()->getName() ?></a> par <?php echo $entry->getSfGuardUser()->getUsername() ?>.<br />
    Mots-clés : <?php foreach($entry->getTags() as $tag): ?> <a href="<?php echo url_for('post_tag', array('tag' => $tag, 'sf_format' => 'html')) ?>" title="voir les articles avec le mot-clé <?php echo $tag ?>"><?php echo $tag; ?></a> <?php endforeach; ?></p>
    
    <div id="content">
      <?php echo $entry->getContent(ESC_RAW) ?>
    </div>
  </div>

<?php } ?>