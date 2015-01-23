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
 * Manager Class zum bearbeiten der ACLs
 * @package net.webfrap
 * @todo die queries müssen noch in query objekte ausgelagert werden
 *
 */
class LibAclReader_Db extends LibAclReader
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibAclAdapter_Db $adapter
   */
  public function __construct($adapter)
  {

    $this->env = $adapter;
    $this->model = $adapter->getModel();

  }//end public function __construct */

  /**
   * Die UserIds aller Benutzer mit den Rollen X auf der Entity Y zurückgeben
   * Optional in relation zu einer/mehreren bestimmten Area/s
   *
   * @param array $roles
   * @param Entity $entity
   * @param array $areas
   */
  public function getUserIdsForRolesByEntity($roles, $entity, $areas = [])
  {

    if (!$areas) {

      $dNode = $entity->getDomainNode();
      $areas = array($dNode->aclKey);
    }

    return $this->model->loadExplicitUsers($areas, array($entity->getId()), $roles);

  }//end public function getUserIdsForRolesByEntity */

  /**
   * de:
   * Debug Daten in die Console pushen
   */
  public function debug()
  {

  }//end public function debug */

}//end class LibAclReader_Db

