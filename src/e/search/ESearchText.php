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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class ESearchText
{

  const EQUALS = 1;
  
  const START_WITH = 2;

  const CONTAINS = 3;
  
  const END_WITH = 4;

  const IS_NULL = 5;

  /**
   * @var array
   */
  public static $labels = array(
    self::EQUALS => 'equals',
    self::START_WITH => 'starts with',
    self::CONTAINS => 'contains',
    self::END_WITH => 'ends with',
    self::IS_NULL => 'is empty',
  );
  
  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : ''; // per default custom

  }//end public static function label */

}//end class ESearchText

