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
 * Abstract Class For SysExtention Controllers
 *
 * @package net.buiz
 */
interface ISerializeable
{

  /**
   * return all data to serialize in an array, only arrays an scalares
   * @return  array
   */
  public function serialize();

  /**
   * @param write back the data in de new object vor deserializing
   */
  public function deserialize($data);

} // end interface ISerializeable
