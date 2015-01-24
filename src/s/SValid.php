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
final class SValid
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /**
   * Extrahieren der ACL Teile der URL zusammebauen zu einem
   * validen ACL Url String
   * @param Context $params
   * @return string
   */
  public static function text($text)
  {
    return htmlentities($text,null,'UTF-8');

  }//end public static function buildAcl */

}// end final class SValid

