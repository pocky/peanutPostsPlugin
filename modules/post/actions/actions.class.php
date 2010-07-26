<?php

/**
 * post actions.
 *
 * @package    peanut
 * @subpackage post
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class postActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->entries = Doctrine::getTable('peanutPosts')->getAll();
    $this->forward404Unless($this->entries);
  }
  
  public function executeCategory(sfWebRequest $request)
  {
    $this->entries = Doctrine::getTable('peanutPosts')->getAllWhereCategory($request->getParameter('categoryName'));
    $this->forward404Unless($this->entries);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->entry = Doctrine::getTable('peanutPosts')->getWhereSlug($request->getParameter('slug'));
    $this->forward404Unless($this->entry);
  }
  
  public function executeAuthor(sfWebRequest $request)
  {
    $this->entries = Doctrine::getTable('peanutPosts')->getAllWhereAuthor($request->getParameter('sfGuardUsername'));
    $this->forward404Unless($this->entries);
  }
  
  public function executeTag(sfWebRequest $request)
  {
    $p = PluginTagTable::getObjectTaggedWithQuery('peanutPosts', $request->getParameter('tag'));
    $p->andWhere('peanutPosts.status = ?', 'publish');
    $p->orderBy('peanutPosts.created_at DESC');
    $this->entries = $p->execute();
    
    $this->forward404Unless($this->entries);
  }
}
