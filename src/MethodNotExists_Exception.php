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
 * Wird geworfen wenn eine nicht existierende Methode auf einer Classe 
 * mit __call / mapping aufgerufen wird
 * 
 * @package net.buiz
 *
 */
class MethodNotExists_Exception extends BuizSys_Exception
{

  /**
   * @param string $object
   * @param string $message
   * @param string $arguments
   */
  public function __construct($object, $method, $arguments = [])
  {

    $message = 'The method '.$method.' not exists on class '.get_class($object).' args: '.implode(', ', array_keys($arguments)) ;

    parent::__construct($message);

  }//end public function __construct */

}//end class MethodNotExists_Exception

