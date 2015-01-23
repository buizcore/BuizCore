<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * Dao Class to Load the Menus from wherever.
 * This Class should be used instead of a loading method
 *
 * @package net.webfrap
 */
class DaoMenu extends Dao
{
/*////////////////////////////////////////////////////////////////////////////*/
//  Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public $data = [];

  /**
   *
   * @var array
   */
  public $view = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Static Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  protected static $pool = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $files
   */
  public function __construct($files)
  {

    $this->view = View::getActive();

    foreach ($files as $file)
      include $file->getName(true);

  }//end public function __construct */

  /**
   *
   */
  public function getData()
  {
    return $this->data;
  }//end public function getData */

/*////////////////////////////////////////////////////////////////////////////*/
// Static Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $mapName
   * @return DaoMenu
   */
  public static function get($menuName, $all = false  )
  {
    if (isset(self::$pool[$menuName]))
      return self::$pool[$menuName];
    else
      return self::load($menuName, $all);

  }//end public static function get */

  /**
   *
   * @param string $menuName the search path for the menu entries
   * @param boolean $all should the system search in every conf folder or use the first menu it finds
   * @return array
   */
  public static function load($menuName , $all = false)
  {

    self::$pool[$menuName] = [];

    foreach (Conf::$confPath as $path) {

      $menuPath = $path.'/menu/'.$menuName.'/';

      if (!file_exists($menuPath))
        continue;

      $folder = new LibFilesystemFolder($menuPath);

      $menuData = new DaoMenu($folder->getFiles());
      $menuData = $menuData->getData();

      Debug::console($menuPath ,$menuData);

      self::$pool[$menuName] = array_merge(self::$pool[$menuName], $menuData) ;

       // break after found data
       if (!$all)
        break;
    }

    return self::$pool[$menuName];

  }//end public static function load */

}//end class DaoMenu

