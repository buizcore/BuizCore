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
 * class LibDb_Exception
 * the database exception, this exception always will be thrown on database errors
 * @package net.buiz
 */
class LibDbImport_Exception extends LibDb_Exception
{

  /**
   * @param string $message
   */
  public function __construct($message = null)
  {

    $this->delete = true;

    if (!$message)
      $message = 'just forget the dataset';

    parent::__construct($message);

  }//end public function __construct */

}//end class LibDbImportForget_Exception

