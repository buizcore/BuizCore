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
 * Ein Link auf Google Maps
 * 
 * @package net.buiz
 */
class FormatLinkGoogleMaps
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param float $number
   */
  public static function format( $label, $coordX, $cordY = null, $zoom = 13 )
  {
    
    // wenn start oder ende fehlen, dann 0 per definition
    if ( '' == trim($coordX))
      return '';
    
    if ($cordY)
      $coordX = $coordX.','.$cordY;

    return '<a href="http://maps.google.de/maps?q='.$coordX.'&z='.$zoom.'" target="'.Wgt::EXTERN_WIN_NAME.'" >'.$label.'</a>';
    
  }//end public static function format */

} // end class FormatLinkGoogleMaps
