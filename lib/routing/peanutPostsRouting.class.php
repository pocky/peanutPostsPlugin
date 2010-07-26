<?php

class peanutPostsRouting
{
  /**
   * Adds an sfDoctrineRouteCollection collection to manage permissions.
   *
   * @param sfEvent $event
   * @static
   */

  static public function addRouteForPost(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('post_index', new sfDoctrineRoute('/blog/index.:sf_format', array(
      'module' => 'post',
      'action' => 'index'
    ), array(
      'sf_method' => 'get'
    ), array(
      'model' => 'peanutPost',
      'type' => 'object'
    )));
  }
    
  static public function addRouteForPostAuthor(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('post_author', new sfDoctrineRoute('/blog/author/:sfGuardUsername.:sf_format', array(
      'module' => 'post',
      'action' => 'author'
    ), array(
      'sf_method' => 'get'
    ), array(
      'model' => 'peanutPost',
      'type' => 'object'
    )));
  }

  
  static public function addRouteForPostShow(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('post_show', new sfDoctrineRoute('/blog/:categoryName/:slug.:sf_format', array(
      'module' => 'post',
      'action' => 'show'
    ), array(
      'sf_method' => 'get'
    ), array(
      'model' => 'peanutPost',
      'type' => 'object'
    )));
    
  }
  
  static public function addRouteForPostCategories(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('post_category', new sfDoctrineRoute('/blog/:categoryName.:sf_format', array(
      'module' => 'post',
      'action' => 'category'
    ), array(
      'sf_method' => 'get'
    ), array(
      'model' => 'peanutPost',
      'type' => 'object'
    )));
  }
  
  static public function addRouteForPostTag(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('post_tag', new sfDoctrineRoute('/blog/tag/:tag.:sf_format', array(
      'module' => 'post',
      'action' => 'tag'
    ), array(
      'sf_method' => 'get'
    ), array(
      'model' => 'peanutPost',
      'type' => 'object'
    )));
  }
  
  
  /**
   * Adds an sfDoctrineRouteCollection collection to manage users.
   *
   * @param sfEvent $event
   * @static
   */
  static public function addRouteForBackendPosts(sfEvent $event)
  {
    $event->getSubject()->prependRoute('peanut_posts', new sfDoctrineRouteCollection(array(
      'name'                => 'peanut_posts',
      'model'               => 'peanutPosts',
      'module'              => 'backendPosts',
      'prefix_path'         => '/backendPosts',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  /**
   * Adds an sfDoctrineRouteCollection collection to manage groups.
   *
   * @param sfEvent $event
   * @static
   */
  static public function addRouteForBackendCategories(sfEvent $event)
  {
    $event->getSubject()->prependRoute('peanut_categories', new sfDoctrineRouteCollection(array(
      'name'                => 'peanut_categories',
      'model'               => 'peanutCategories',
      'module'              => 'backendCategories',
      'prefix_path'         => '/backendCategories',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }
  
  /**
   * Adds an sfDoctrineRouteCollection collection to manage groups.
   *
   * @param sfEvent $event
   * @static
   */
  static public function addRouteForBackendTag(sfEvent $event)
  {
    $event->getSubject()->prependRoute('tag', new sfDoctrineRouteCollection(array(
      'name'                => 'tag',
      'model'               => 'tag',
      'module'              => 'backendTag',
      'prefix_path'         => '/backendTag',
      'with_wildcard_routes' => true,
      'collection_actions'  => array(),
      'requirements'        => array(),
    )));
  }
}