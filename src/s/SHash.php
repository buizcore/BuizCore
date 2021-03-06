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
 * Container für url methoden
 * @package net.buiz
 */
final class SHash
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /**
   * @var string
   */
  const ALLOWED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  
  /**
   * 
   */
  public static function createIntHash ($key, $base = self::ALLOWED_CHARS) {
  
      $length = strlen($base);
      $out = '';
      while($key > $length - 1) {
          $pos = (int)fmod($key, $length);
          echo $pos.' '.$length.'<br />';
          $out = (isset($base[$pos])
              ? $base[$pos]
              :'').$out;
          $key = (int)floor( $key / $length );
      }
      return (isset($base[$key])?$base[$key]:'') . $out;
      
  }//end createIntHash */
  
}// end final class SHash

