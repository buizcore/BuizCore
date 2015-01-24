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
 * @author Dominik Donsch <dominik.bonsch@buiz.net>
 *
 */
abstract class LibProcessSlice
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var Process
   */
  public $process = null;

  /**
   * Die Daten für den Slice
   * @var array
   */
  public $sliceData = [];

  /**
   * @var LibAclPermission
   */
  public $access = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Standard Konstruktor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Process $process
   * @param array $slice
   */
  public function __construct($process, $slice)
  {

    $this->process = $process;
    $this->sliceData = $slice;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// check methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function getAccess()
  {
    return $this->access;
  }//end public function getAccess */

  /**
   * @return string
   */
  abstract public function getRenderer();

/*////////////////////////////////////////////////////////////////////////////*/
// Debug Data
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Methode zum bereitstellen notwendiger Debugdaten
   * Sinn ist es möglichst effizient den aufgetretenen Fehler lokalisieren zu
   * können.
   * Daher sollte beim implementieren dieser Methode auch wirklich nachgedacht
   * werden.
   * Eine schlechte debugData Methode ist tendenziell eher schädlich.
   *
   * @return string
   */
  abstract public function debugData();

}//end class LibProcessSlice

