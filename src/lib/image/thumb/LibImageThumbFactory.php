<?php
/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @date        :
 * @copyright   : Webfrap Developer Network <contact@webfrap.net>
 * @project     : Webfrap Web Frame Application
 * @projectUrl  : http://webfrap.net
 *
 * @licence     : BSD License see: LICENCE/BSD Licence.txt
 *
 * @version: @package_version@  Revision: @package_revision@
 *
 * Changes:
 *
 *******************************************************************************/

/**
 * class LibImageThumbFactory
 *
 * @package net.webfrap
 */
class LibImageThumbFactory
{

  /**
   * Erstellen einer Thumb Library
   *
   * @return LibImageThumbAdapter
   */
  public static function getThumb($origName = null ,$thumbName = null ,$maxWidth = null ,$maxHeight = null)
  {

    if (defined('WBF_IMAGE_LIB')) {
      $type = WBF_IMAGE_LIB;
    } else {
      $type = 'Gd';
    }

    $className = 'LibImageThumb'.$type;

    return new $className($origName,$thumbName,$maxWidth,$maxHeight);

  }//end ublic static function getThumb

}// end class LibImageThumbFactory

