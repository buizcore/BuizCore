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
class LibSanitizer_Rudimental
  implements LibSanitizerAdapter
{

  /**
   * Methode zum entfernen unerwünschter Tags und Attribute aus HTML
   *
   * Nicht unbedingt ein traum, vermutlich unsecure as hell, aber
   * man wird schon wissen warum man das anstelle von HtmlPurifier verwendet...
   *
   * @param string $raw
   * @param string $encoding
   * @param string $configKey
   *
   * @return string
   */
  public function sanitize($raw, $encoding = 'utf-8', $configKey = 'default')
  {

    Debug::console("Used unsecure Rudimental Sannitizer Plugin!");
    Log::warn("Used unsecure Rudimental Sannitizer Plugin! Besser use the HTMLPurifier Adapter in BuizCore_Lib_Htmlpurifier");

    return strip_tags(
      $raw,
      '<span><p><h1><h2><h3><h4><h5><h6><label><div><ul><ol><li><i><b><em><strong>'
     );

  }//end public function sanitize */

}//end class LibSanitizer_Rudimental
