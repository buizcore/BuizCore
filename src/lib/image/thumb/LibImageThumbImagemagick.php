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
 * class LibmageThumbImagemagick
 *
 * @package net.webfrap
 */
class LibmageThumbImagemagick extends LibImageThumbAdapter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function genThumb()
  {

    $thumb = new Imagick();

    $thumb->readImage($this->origName);
    $thumb->resizeImage($this->maxWidth,$this->maxHeight,Imagick::FILTER_LANCZOS,1);
    $thumb->writeImage($this->thumbName);
    $thumb->clear();
    $thumb->destroy();

  }//end public function genThumb

}// end class ObjImageThumbgen

