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
class LibResponse extends PBase
{

  public $view = null;

  /**
   * Setup der Response
   */
  public function init()
  {

    $this->getI18n();

  }//end public function init */

  /**
   * Ausgabe
   */
  public function out()
  {

  }//end public function init */

  /**
   * @return LibResponseContext
   */
  public function createContext()
  {
    return new LibResponseContext($this);

  }//end public function createContext */

} // end LibResponse

