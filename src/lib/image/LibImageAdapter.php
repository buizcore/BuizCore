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
 * @package net.webfrap
 */
abstract class LibImageAdapter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $imagePath = null;

  /**
   * @var string
   */
  public $imageName = null;

  /**
   * Pfad zu einem Fehlerimage, das geladen wird, wenn das Original Bild
   * nicht geladen werden konnte
   * z.B wenn ein Thumb für ein nicht unterstütztes bildformat erstellt werden soll
   * @var string
   */
  public $pathErrorImage = null;

  /**
   * Ist true wenn das Error Image geladen wurde
   * @var boolen
   */
  public $errorState = false;

  /**
   * Die Bild Resource
   * @var string
   */
  public $resource = null;

  /**
   * @var int
   */
  public $width = null;

  /**
   * @var int
   */
  public $height = null;

  /**
   * @var string
   */
  public $type = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  abstract public function open($imagePath);

  /**
   */
  //public abstract function genThumb();

}// end abstract class LibImageThumbAdapter
