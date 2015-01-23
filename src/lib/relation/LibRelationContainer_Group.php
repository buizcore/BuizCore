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
 *
 * @package net.webfrap
 */
class LibRelationContainer_Group implements LibRelationContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysRoleGroup_Entity
   */
  public $group = null;

  /**
   * @var id
   */
  public $id = null;

  /**
   * @var string
   */
  public $name = null;

  /**
   * @var string
   */
  public $area = null;

  /**
   * @var string
   */
  public $entity = null;

  /**
   * @var string
   */
  public $type = 'group';

  /**
   * @var array<IReceiver>
   */
  public $else = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param mixed $group
   * @param string $area
   * @param Entity $entiy
   * @param array<IReceiver> $else
   */
  public function __construct($group, $area = null, $entiy = null, $else = [])
  {

    if (is_object($group)) {
      $this->group = $group;
    } elseif (is_numeric($group)) {
      $this->id = $group;
    } else {
      $this->name = $group;
    }

    $this->area = $area;
    
    $this->entity = $entiy;

    $this->else = $else;

  }//end public function __construct */

} // end LibRelation_Group

