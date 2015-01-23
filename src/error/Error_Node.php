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
class Error_Node
{

  /**
   * Die genaue Fehlermeldung
   * @var string
   */
  public $errorMessage = null;

  /**
   * Der HTTP Fehlercode
   * @var int
   */
  public $errorCode = null;

/*////////////////////////////////////////////////////////////////////////////*/
//
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function getMessage()
  {
    return $this->errorMessage;
  }//end public function getMessage */

  /**
   * @return int
   */
  public function getCode()
  {
    return $this->errorCode;
  }//end public function getCode */

} // end class Error_Node
