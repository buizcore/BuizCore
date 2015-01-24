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
 */
class EAmple
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var int
    */
    const GREEN = 1;
    
   /**
    * @var int
    */
    const YELLOW = 2;
    
   /**
    * @var int
    */
    const RED = 3;

/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

    public static $labels = array(
        self::GREEN => 'Green',
        self::YELLOW => 'Yellow',
        self::RED => 'Red',
    );
    
    public static $colors = array(
        self::GREEN => '#00C000',
        self::YELLOW => '#F4F400',
        self::RED => '#FF0000',
    );
    
    public static $icons = array(
        self::GREEN => '<i class="fa fa-circle" style="color:#00C000;" ></i>',
        self::YELLOW => '<i class="fa fa-warning-sign" style="color:#F4F400;" ></i>',
        self::RED => '<i class="fa fa-exclamation-sign" style="color:#FF0000;" ></i>',
    );
  
  
  /**
   * @param int $idx
   * @return string
   */
  public static function color( $idx )
  {
  
  	return isset(self::$colors[$idx])?self::$colors[$idx]:null;
  
  }//end public static function color */
  
  /**
   * @param int $idx
   * @return string
   */
  public static function icon( $idx )
  {
  
  	return isset(self::$icons[$idx])?self::$icons[$idx]:null;
  
  }//end public static function icon */
  
  /**
   * @param int $idx
   * @return string
   */
  public static function label( $idx )
  {
  
  	return isset(self::$labels[$idx])?self::$labels[$idx]:null;
  
  }//end public static function label */

}//end class EAmple

