<?php


abstract class PluginpeanutCategoriesTable extends Doctrine_Table
{ 
  public static function getInstance()
  {
    return Doctrine_Core::getTable('peanutCategories');
  }
}