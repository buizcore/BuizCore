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
 * @package net.buiz
 */
class LibRelationContainer_User implements LibRelationContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var BuizRoleUser_Entity
   */
  public $user = null;

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
  public $type = 'user';

  /**
   * @var array<IReceiver>
   */
  public $else = [];

  /**
   * @param mixed $user
   */
  public function __construct($user)
  {

    if (is_object($user)) {
      $this->user = $user;
    } elseif (is_numeric($user)) {
      $this->id = $user;
    } else {
      $this->name = $user;
    }

  }//end public function __construct */

} // end LibRelationContainer_User

