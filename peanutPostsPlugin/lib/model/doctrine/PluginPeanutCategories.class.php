<?php

/**
 * peanutCategories
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    peanut
 * @subpackage model
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginPeanutCategories extends BasepeanutCategories
{
  public function __toString()
  {
    return $this->getName();
  }
  
  public function ReadyToChoice()
  {
    return sprintf('%s', $this->getIndentedName());
  }
  
  public function getParentId()
  {
    if (!$this->getNode()->isValidNode() || $this->getNode()->isRoot())
    {
      return null;
    }

    $parent = $this->getNode()->getParent();

    return $parent['id'];
  }

  public function getIndentedName()
  {
    return str_repeat('- ',$this['level']).$this['name'];
  }
  
}
