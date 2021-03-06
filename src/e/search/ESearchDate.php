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
class ESearchDate
{

  const EQUALS = 1;
  
  const BEFORE = 2;

  const BEFORE_EQUAL = 3;
  
  const AFTER = 4;
  
  const AFTER_EQUAL = 5;
  
  const IS_NULL = 6;
  
  /**
   * @var array
   */
  public static $labels = array(
    self::EQUALS => 'equals',
    self::BEFORE => 'before',
    self::BEFORE_EQUAL => 'before or equal',
    self::AFTER => 'after',
    self::AFTER_EQUAL => 'after or equal',
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

}//end class ESearchDate

