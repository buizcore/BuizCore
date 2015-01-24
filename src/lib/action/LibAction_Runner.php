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
 *
 */
class LibAction_Runner extends Pbase
{


  /**
   * @param string $string
   */
  public function executeByString($string, array $params = [])
  {
    
    $action = json_decode($string);
    return $this->execute($action, $params);

  }//end public function executeByString */

  /**
   * @param stdClass $action
   * @throws LibAction_Exception
   */
  public function execute($action, array $params = [])
  {

    $className = $action->class;
    $method = $action->method;

    if (!BuizCore::classExists($className)) {
      throw new LibAction_Exception('Class '.$className.' does not exist.');
    }

    $actionObj = new $className($this);

    if(!method_exists($actionObj, $method)){
      throw new LibAction_Exception('Class '.$className.' does not exist.');
    }

    return $actionObj->$method($params);

  }//end public function execute */


}

