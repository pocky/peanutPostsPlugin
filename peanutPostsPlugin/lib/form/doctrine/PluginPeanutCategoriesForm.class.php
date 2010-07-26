<?php

/**
 * peanutCategories form.
 *
 * @package    form
 * @subpackage peanutCategories
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginpeanutCategoriesForm extends BasepeanutCategoriesForm
{
  protected $parentId = null;
  
  public function setup()
  {
    parent::setup();
    
    $this->widgetSchema['parent'] = new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'peanutCategories',
      'add_empty' => 'This is a first level category',
    ));
    
    $this->validatorSchema['parent'] = new sfValidatorDoctrineChoiceNestedSet(array(
      'required' => false,
      'model'    => 'peanutCategories',
      'node'     => $this->getObject(),
    ));
    
    if($this->getObject()->getNode()->hasParent())
    {
      $this->setDefault('parent', $this->getObject()->getNode()->getParent()->getId());
    }
    
    $this->useFields(array(
      'name',
      'description',
      'parent',
    ));

    
    $this->setValidator('parent', new sfValidatorDoctrineChoiceNestedSet(array(
      'required'    => false,
      'model'       => 'peanutCategories',
      'node'        => $this->getObject(),
    )));
    
    $this->getValidator('parent')->setMessage('node', 'A category cannot be made a descend of itself!');
  }
  
  protected function doSave($con = null)
  {
    parent::doSave($con);
    
    $node = $this->object->getNode();
    
    if($this->getValue('parent'))
    {
      $parent = Doctrine::getTable('peanutCategories')->findOneById($this->getValue('parent'));
      if($this->isNew())
      {
        $this->getObject()->getNode()->insertAsLastChildOf($parent);
      }
      else
      {
        $this->getObject()->getNode()->moveAsLastChildOf($parent);
      }
    }
    else
    {
      $categoryTree = Doctrine::getTable('peanutCategories')->getTree();
      if($this->isNew())
      {
        $categoryTree->createRoot($this->getObject());
      }
      else
      {
        $this->getObject()->getNode()->makeRoot($this->getObject()->getId());
      }
    }
  }
}