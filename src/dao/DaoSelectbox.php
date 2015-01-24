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
 * Dato zum laden con PHP Maps
 * @package net.buiz
 */
class DaoSelectbox extends Dao
{

  /**
   *
   * @var unknown_type
   */
  protected static $pool = [];

  /**
   *
   * @param $mapName
   * @return unknown_type
   */
  public static function get($mapName)
  {

    if (isset(self::$pool[$mapName]))
      return self::$pool[$mapName];
    else
      return DaoSelectbox::load($mapName);

  }//end public static function get

  /**
   *
   * @param unknown_type $mapName
   * @return unknown_type
   */
  public static function load($mapName)
  {

    foreach (Conf::$confPath as $path) {

      $menuPath = $path.'/selectbox/'.$mapName.'/';

      if (!file_exists($menuPath))
        continue;

      $folder = new LibFilesystemFolder($menuPath);

      foreach ($folder->getFiles() as $file)
        include $file->getName(true);

       // break after found data
       break;
    }

  }//end public static function load

}//end class DaoNative

