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
 * @package net.buiz
 *
 */
class TIcon
{
/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $name
   * @param $size
   * @param $alt
   */
  public static function create($name , $size , $attributes = [])
  {

    $pAttributes = '';

    if ($attributes)
      $pAttributes = self::asmAttributes($attributes);

    $html = '<img src="'.View::$webIcons.$size.'/'.$name.'" class="icon '.ucfirst($size).'" '
      .$pAttributes."  />".NL;

    return $html;

  }//end public function create */

  /**
   * the attributes for the icon
   * @return string attributes
   */
  protected static function asmAttributes($attributes)
  {

    $html = '';

    foreach ($attributes as $key => $value)
      $html .= $key.'="'.$value.'" ';

    return $html;

  }// end protected static function asmAttributes */

}//end class TIcon

