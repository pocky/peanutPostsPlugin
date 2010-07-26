<?php

/**
 * category components.
 *
 * @package    peanut
 * @subpackage category
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryComponents extends sfComponents
{
  public function executeMenu(sfWebRequest $request)
  {
    $this->roots = Doctrine::getTable('peanutCategories')->getTree()->fetchRoots();
  }
}
