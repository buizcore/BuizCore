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
 * @package net.webfrap
 */
class LibImageThumbSystemImagemagick extends LibImageThumbAdapter
{

  /**
   * Enter description here...
   *
   */
  public function genThumb()
  {

    system("convert $this->origName -resize ".$this->maxWidth."x".$this->maxHeight." $this->thumbName");

  }//end public function genThumb

}// end class LibImageThumbSystemImagemagick
