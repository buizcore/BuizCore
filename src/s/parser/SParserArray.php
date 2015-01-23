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
 * @package net.webfrap
 */
final class SParserArray
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /**
   * fusion the first layer of a multidim array
   *
   * @param array $arr
   * @return array
   */
  public static function multiDimFusion($arr)
  {

    $data = [];

    foreach ($arr as $tmp) {
      foreach ($tmp as $tmp2) {
        ///FIXME figure out why php5.2.5 needs a trim() here an earlier versions not
        $data[] = trim($tmp2);
      }
    }

    return $data;

  }//end public static function childParentFusion */

}// end class SParserString

