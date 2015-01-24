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
 * @package net.buiz
 */
class DaoDatasource extends Dao
{
/*////////////////////////////////////////////////////////////////////////////*/
//  Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public $data = [];

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
   * @param array $data
   */
  public function __construct($data)
  {

    $this->data = $data;

  }//end public function __construct */

  /**
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }//end public function getData */

/*////////////////////////////////////////////////////////////////////////////*/
// Static Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $sourceName
   * @param boolean $all
   * @param string $path
   * @return DaoMenu
   */
  public static function get($sourceName, $all = false, $path = 'data'  )
  {
    if (isset(self::$pool[$sourceName]))
      return self::$pool[$sourceName];
    else
      return self::load($sourceName, $all, $path);

  }//end public static function get */

  /**
   * @param string $sourceName the search path for the menu entries
   * @param boolean $all should the system search in every conf folder or use the first menu it finds
   * @param string $path
   * @return array
   */
  public static function load($sourceName , $all = false, $path = 'data')
  {

    self::$pool[$sourceName] = [];

    $menuPath = PATH_GW.'/'.$path.'/'.$sourceName;

    if (!file_exists($menuPath)) {
      Debug::console('found no source: '.$menuPath);

      return null;
    }

    $folder = new LibFilesystemFolder($menuPath);

    $menuData = new DaoDatasource($folder->getFiles());

    self::$pool[$sourceName] = $menuData ;

    return self::$pool[$sourceName];

  }//end public static function load */

}//end class DaoDatasource

