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
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcessSlice_Confirm extends LibProcessSlice
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////*/
// check methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return WgtProcessFormSlice_Confirm
   */
  public function getRenderer()
  {
    return new WgtProcessFormSlice_Confirm($this);
  }//end public function getRenderer */

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
  public function debugData()
  {
    return 'Slice Confirm';

  }//end public function debugData */

}//end class LibProcessSlice_Confirm

