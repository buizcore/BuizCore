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
 *
 * @package net.buiz
 *
 * @author domnik alexander bonsch <dominik.bonsch@buiz.net>
 */
class DomainLabel
{

  /**
   * @var [DomainNode]
   */
  private static $pool = [];
  
  /**
   * @param string $key
   * @return DomainLabel
   */
  public static function getNode($key)
  {
  
      if (!array_key_exists($key, self::$pool)) {
  
          $className = SParserString::subToCamelCase($key).'_Label';
  
          if (!BuizCore::classExists($className)) {
              self::$pool[$key] = null;
              return null;
          }
  
          self::$pool[$key] = new $className;
      }
  
      return self::$pool[$key];
  
  }//end public static function getNode */

  /**
   * @param string $key
   * @return DomainNode
   */
  public function text($entity)
  {

    return $entity->text();

  }//end public function getNode */

}//end class DomainLabel
