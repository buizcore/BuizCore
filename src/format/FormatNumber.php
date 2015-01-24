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
 * Die Dauer eines Vorgangs aus dem Start und Endedatum heraus berechnen
 * 
 * @package net.buiz
 */
class FormatNumber
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param float $number
   * @param int $decimals
   */
  public static function format($number, $decimals = 2)
  {
    
    // wenn start oder ende fehlen, dann 0 per definition
    if (!$number)
      $number = 0;

    return number_format($number, $decimals);
    
  }//end public static function format */

} // end class FormatNumber
