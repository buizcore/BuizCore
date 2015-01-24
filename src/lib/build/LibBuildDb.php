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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class LibBuild extends LibBuildAction
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param unknown_type $node
   * @return unknown_type
   */
  public function execute()
  {

    $type = $this->args[0];
    $action = $this->args[1];

    $className = 'LibBuildDb'.ucfirst($type);

    if (!BuizCore::classExists($className)) {
      Error::addError('Requested invalid Db Type: '.$type.'. Please Check you Buildconfiguration.');

      return false;
    }

    $repoObj = new $className();

    if (!method_exists($repoObj , $action)) {
      Error::addError('Requested invalid Db Action: '.$action.' for Db: '.$type.'. Please Check you Buildconfiguration.');

      return false;
    }

    return $repoObj->$action();

  }//end public function execute */

} // end class LibGenfBuild

