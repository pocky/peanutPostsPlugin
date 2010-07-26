<?php

require_once dirname(__FILE__).'/../lib/backendCategoriesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/backendCategoriesGeneratorHelper.class.php';

/**
 * backendCategories actions.
 *
 * @package    peanut
 * @subpackage backendCategories
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendCategoriesActions extends autoBackendCategoriesActions
{
  
  protected function addSortQuery($query)
  {
    $query->addOrderBy('root_id asc');
    $query->addOrderBy('lft asc');
  }
  
  public function executeBatch(sfWebRequest $request)
  {
    if ("batchOrder" == $request->getParameter('batch_action'))
    {
      return $this->executeBatchOrder($request);
    }
    
    parent::executeBatch($request);
  }
  
  public function executeUp()
  {
    $object = Doctrine::getTable('peanutCategories')->find($this->getRequestParameter('id'));
    $node = $object->getNode();
    
    if($node->isValidNode() && $node->hasPrevSibling())
    {
      $sibling = Doctrine::getTable('peanutCategories')->find($node->getPrevSibling()->getId());
      
      $node->moveAsPrevSiblingOf($sibling);
      $object->save();
      
      $this->getUser()->setFlash('notice', 'Order Updated!');
    }
    else
    {
      $this->getUser()->setFlash('error', 'This category do not have previous sibling');
    }
    
    $this->redirect("@peanut_categories");
  }
  
  public function executeDown()
  {
    $object = Doctrine::getTable('peanutCategories')->find($this->getRequestParameter('id'));
    $node = $object->getNode();
    
    if($node->isValidNode() && $node->hasNextSibling())
    {
      $sibling = Doctrine::getTable('peanutCategories')->find($node->getNextSibling()->getId());
      
      $node->moveAsNextSiblingOf($sibling);
      $object->save();
      
      $this->getUser()->setFlash('notice', 'Order Updated!');
    }
    else
    {
      $this->getUser()->setFlash('error', 'This category do not have next sibling');
    }

    $this->redirect("@peanut_categories");
  }
  
  public function executeMakeRoot()
  {
    $object = Doctrine::getTable('peanutCategories')->find($this->getRequestParameter('id'));
    $node = $object->getNode();
    
    if($node->isValidNode() && $node->hasParent())
    {
      
      $node->makeRoot($this->getRequestParameter('id'));
      $object->save();
      
      $this->getUser()->setFlash('notice', 'Order Updated!');
    }
    else
    {
      $this->getUser()->setFlash('error', 'This category do not have a parent');
    }
    
    $this->redirect("@peanut_categories");
  }
  
  public function executeBatchOrder(sfWebRequest $request)
  {
    $newparent = $request->getParameter('newparent');
    
    $ids = array();
    foreach ($newparent as $key => $val)
    {
      $ids[$key] = true;
      if (!empty($val))
        $ids[$val] = true;
    }
    $ids = array_keys($ids);
    
    $validator = new sfValidatorDoctrineChoice(array('model' => 'peanutCategories', 'multiple' => true));
    try
    {
      $ids = $validator->clean($ids);

      $count = 0;
      $flash = "";

      foreach ($newparent as $id => $parentId)
      {
        if (!empty($parentId))
        {
          $node = Doctrine::getTable('peanutCategories')->find($id);
          $parent = Doctrine::getTable('peanutCategories')->find($parentId);
          
          if (!$parent->getNode()->isDescendantOfOrEqualTo($node))
          {
            $node->getNode()->moveAsFirstChildOf($parent);
            $node->save();

            $count++;

            $flash .= "<br/>Moved '".$node['name']."' under '".$parent['name']."'.";
          }
        }
      }

      if ($count > 0)
      {
        $this->getUser()->setFlash('notice', sprintf("peanutCategories order updated, moved %s item%s:".$flash, $count, ($count > 1 ? 's' : '')));
      }
      else
      {
        $this->getUser()->setFlash('error', "You must at least move one item to update the peanutCategories order");
      }
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'Cannot update the peanutCategories order, maybe some item are deleted, try again');
    }
     
    $this->redirect('@peanut_categories');
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $object = $this->getRoute()->getObject();
    if ($object->getNode()->isValidNode())
    {
      $object->getNode()->delete();
    }
    else
    {
      $object->delete();
    }

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    $this->redirect('@peanut_categories');
  }

  public function executeListNew(sfWebRequest $request)
  {
    $this->executeNew($request);
    $this->form->setDefault('parent', $request->getParameter('id'));
    $this->setTemplate('edit');
  }
  
}