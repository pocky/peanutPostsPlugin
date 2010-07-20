<?php

/**
 * peanutPosts form.
 *
 * @package    peanut
 * @subpackage form
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPeanutPostsForm extends BasepeanutPostsForm
{
  public function setup()
  {
    parent::setup();
    
    $user = self::getValidUser();
        
    unset($this['updated_at']);
    
    $this->widgetSchema->setHelps(array(
      'slug'     => 'The field is not required',
      'excerpt'  => 'The field is not required',
    ));
    
    $this->widgetSchema->moveField('slug', sfWidgetFormSchema::AFTER, 'title');
    
    $this->widgetSchema['content'] = new sfWidgetFormCKEditor(array('jsoptions' => array(
    	'customConfig'				      => '/js/ckeditor/config.js',
    	'filebrowserBrowseUrl'		  => '/js/filemanager/index.html',
    	'filebrowserImageBrowseUrl'	=> '/js/filemanager/index.html?type=Images',
    )));
    
    $this->widgetSchema['category'] = new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'peanutCategories',
    ));

    $this->widgetSchema['status'] = new sfWidgetFormChoice(array(
    	'choices'	=> Doctrine::getTable('PeanutPosts')->getStatus(),
    	'expanded'	=> false,
    ));
    
    if(!$this->isNew()) {
      $this->widgetSchema['created_at'] = new sfWidgetFormI18nDate(array(
        'culture' => $user->getCulture(),
      ));
    }
    else
    {
      unset($this['created_at']);
    }
    
    /**
     * Add tags for peanutPostsForm
     * 
     * @author http://n8v.enteuxis.org/2010/05/adding-wordpress-like-tags-to-a-symfony-1-4-admin-generator-form/
     *
     */
     
     $default = 'Add tags with commas';
     $this->widgetSchema['new_tags'] = new sfWidgetFormInput(array(
       'default'       => $default,
     ),
     array(
       'onclick'       => "if(this.value=='$default') { this.value = ''; this.style.color='black'; }",
       'size'          => '32',
       'id'            => 'new_tags',
       'autocomplete'  => 'off',
       'style'         => 'color: #aaa;'       
     ));
     
     $this->setValidator('new_tags', new sfValidatorString(array(
       'required'      => false,
     )));
     
     $this->widgetSchema['remove_tags'] = new sfWidgetFormInputHidden();
     $this->setValidator('remove_tags', new sfValidatorString(array(
       'required'      => false,
     )));
  }
}
