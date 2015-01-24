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
 * Bibliothek zum reinigen von potentiell gefährlichem Userinhalt
 *
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @package net.buiz
 */
class LibSanitizer
{

  /**
   * @var LibSanitizerAdapter
   */
  private static $htmlAdapter = null;

  /**
   * @return LibSanitizerAdapter
   */
  public static function getHtmlSanitizer()
  {

    if (!self::$htmlAdapter) {
      //self::$htmlAdapter = new LibSanitizer_Rudimental();

      
      if (BuizCore::classExists('LibVendorHtmlpurifier')) {
        // best solution!
        self::$htmlAdapter = new LibVendorHtmlpurifier();
        //self::$htmlAdapter = new LibSanitizer_Rudimental();
      } else {
        // well let's hope your users like you :-(
        self::$htmlAdapter = new LibSanitizer_Rudimental();
      }
      
    }

    return self::$htmlAdapter;

  }//end public static function getHtmlSanitizer */

}//end class LibSanitizer

