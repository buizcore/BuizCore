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
class Error_ViewNotFound extends Error_Node
{

  /**
   * @see Error_Node::$errorMessage
   */
  public $errorMessage = null;

  /**
   * @see Error_Node::$errorCode
   */
  public $errorCode = Response::NOT_IMPLEMENTED;

  /**
   * @param string $key
   */
  public function __construct($key)
  {

    $this->errorMessage = 'The Requested View '.$key.' is not implemented';

  }//end public function __construct */

} // end class Error_ViewNotFound
