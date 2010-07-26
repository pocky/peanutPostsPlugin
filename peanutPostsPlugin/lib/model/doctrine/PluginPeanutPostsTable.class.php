<?php


abstract class PluginpeanutPostsTable extends Doctrine_Table
{ 
  public static function getInstance()
  {
    return Doctrine_Core::getTable('peanutPosts');
  }
  
  static public $status = array
  (
  	'draft'		=> 'Draft',
  	'publish'	=> 'Publish',
  );
  
  public function getStatus()
  {
  	return self::$status;
  }
  
  
  /**
   * Retrieves a post object where id.
   *
   * @param  int $id The id of the page
   *
   * @return peanutPage
   */
   
  public function getWhereId($id)
  {
    $p = $this->createQuery('p')
      ->leftJoin('p.sfGuardUser s')
      ->leftJoin('p.peanutCategories c')
      ->where('p.id = ?', $id);
      
    return $p->fetchOne();
  }
  
  
  /**
   * Retrieves a post object where slug.
   *
   * @param  string $slug The slug of the page
   *
   * @return peanutPage
   */
   
  public function getWhereSlug($slug)
  {
    $p = $this->createQuery('p')
      ->leftJoin('p.sfGuardUser s')
      ->leftJoin('p.peanutCategories c')
      ->where('p.slug = ?', $slug);
      
    return $p->fetchOne();
  }
  
  /**
   * Retrieves a post object by status.
   *
   * @param  string $status The page's status
   *
   * @return peanutPage
   */
   
  public function getAll($status = 'publish')
  {
    $p = $this->createQuery('p')
      ->leftJoin('p.sfGuardUser s')
      ->leftJoin('p.peanutCategories c')
      ->where('p.status = ?', $status)
      ->orderBy('p.created_at DESC');
      
    return $p->execute();
  }
  
  /**
   * Retrieves a post object by author and status.
   *
   * @param  int or string $author The author of the page
   * @param  string $status The page's status
   *
   * @return peanutPage
   */
   
  public function getAllWhereAuthor($author, $status = 'publish')
  {
    $p = $this->createQuery('p')
      ->leftJoin('p.sfGuardUser s')
      ->leftJoin('p.peanutCategories c')
      ->where('p.author = ?', $author)
      ->orWhere('s.username = ?', $author)
      ->andWhere('p.status = ?', $status)
      ->orderBy('p.created_at DESC');
      
    return $p->execute();
  }
  
  /**
   * Retrieves a post object by category and status.
   *
   * @param  int or string $category The author of the page
   * @param  string $status The page's status
   *
   * @return peanutPage
   */
   
  public function getAllWhereCategory($category, $status = 'publish')
  {
    $p = $this->createQuery('p')
      ->leftJoin('p.sfGuardUser s')
      ->leftJoin('p.peanutCategories c')
      ->where('p.category = ?', $category)
      ->orWhere('c.slug = ?', $category)
      ->andWhere('p.status = ?', $status)
      ->orderBy('p.created_at DESC');
      
    return $p->execute();
  }
  
}