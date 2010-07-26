<?php

require_once dirname(__FILE__).'/../lib/backendPostsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/backendPostsGeneratorHelper.class.php';

/**
 * backendPosts actions.
 *
 * @package    peanut
 * @subpackage backendPosts
 * @author     Alexandre pocky BALMES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendPostsActions extends autoBackendPostsActions
{
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->form->setDefault('author', $this->getUser()->getGuardUser()->getId());
    $this->peanut_posts = $this->form->getObject();
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
      
      // NEW: deal with tags
      if ($form->getValue('remove_tags')) {
        foreach (preg_split('/\s*,\s*/', $form->getValue('remove_tags')) as $tag) {
          $form->getObject()->removeTag($tag);
        }
      }
      
      if ($form->getValue('new_tags')) {
        foreach (preg_split('/\s*,\s*/', $form->getValue('new_tags')) as $tag) {
            // sorry, it would be better to not hard-code this string
        if ($tag == 'Add tags with commas') continue;
          $form->getObject()->addTag($tag);
        }
      }
            
      try {
        $peanut_posts = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $peanut_posts)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@peanut_posts_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'peanut_posts_edit', 'sf_subject' => $peanut_posts));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
  
}
