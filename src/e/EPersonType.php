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
class EPersonType
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Ein Mensch
   * @var int
   */
  const HUMAN_PERSON = 1;

  /**
   * Eine juristische Person (Firma/Organisation)
   * @var int
   */
  const LEGAL_PERSON = 2;

  /**
   * Eine künstliche Person, Figur, Künstleridentität etc.
   * @var int
   */
  const ARTIFICAL_PERSON = 3;

  /**
   * Eine virtuelle Person, (VI, AI, Programm)
   * @var int
   */
  const VIRTUAL_PERSON = 4;

  /**
   * Ein einfacher maschinen account für andere Systeme
   * @var int
   */
  const MACHINE = 5;


/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::HUMAN_PERSON => 'Person',
    self::LEGAL_PERSON => 'Company',
    self::ARTIFICAL_PERSON => 'Artifical Person',
    self::VIRTUAL_PERSON => 'Virtual Person',
    self::MACHINE => 'Machine',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {

    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : null; // sollte nicht passieren

  }//end public static function label */

}//end class EPersonType

