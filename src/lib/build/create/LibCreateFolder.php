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
class LibBuildCreateFile extends LibBuildAction
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return boolean
   */
  public function execute()
  {

    $name = $this->args[1];

    return SFilesystem::mkdir($name, true, true);

  }//end public function execute */

} // end class LibBuildCreateFile

