<?php

/**
 * PluginpeanutPostsTable tests.
 */
include dirname(__FILE__).'/../../../../../../test/bootstrap/unit.php';

$databaseManager = new sfDatabaseManager($configuration);
$tableCat = Doctrine_Core::getTable('peanutCategories');
$tablePost = Doctrine_Core::getTable('peanutPosts');

$tablePost->createQuery()
  ->delete()
  ->where('id = ?', '50')
  ->execute();
  
$tableCat->createQuery()
  ->delete()
  ->where('id = ?', '50')
  ->execute();

$category = new peanutCategories();
$category->id = '50';
$category->name = 'catUnit';
$category->save();

$post = new peanutPosts();
$post->id = '50';
$post->title = 'testUnit';
$post->excerpt = 'test excerpt';
$post->content = 'test content';
$post->author = '1';
$post->category = '50';
$post->status = 'draft';
$post->save();

$t = new lime_test(1);
$t->ok($tablePost->getWhereId(50), '->getWhereId() is ok');

$t = new lime_test(1);
$tablePost = Doctrine_Core::getTable('peanutPosts')->getWhereId('50');
$t->is($tablePost->getId(), '50', '->getWhereId() returns "50"');

$t = new lime_test(1);
$tablePost = Doctrine_Core::getTable('peanutPosts')->getAllWhereAuthor('1')->getFirst();
$t->is($tablePost->getsfGuardUser()->getUsername(), 'admin', '->getWhereAuthor() returns "admin" yepz');

$t = new lime_test(1);
$tablePost = Doctrine_Core::getTable('peanutPosts')->getAllWhereCategory('50')->getFirst();
$t->is($tablePost->getpeanutCategories()->getName(), 'catUnit', '->getWhereCategories() returns "catUnit" yepz');