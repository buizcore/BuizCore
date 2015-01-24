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
 * Buiz Access Controll
 *
 * @package net.buiz
 */
class LibAclAdapter extends BaseChild
{

  /**
   * the user level
   * @var array
   */
  protected $level = [];

  /**
   *
   * @var array
   */
  protected $group = [];

  /**
   *
   * @var array
   */
  protected $extend = [];

  /**
   *
   * @var array
   */
  protected $groupCache = [];

  /**
   *
   * @var array
   */
  protected $lists = [];

  /**
   * flag to enable or disable the check for acls
   *
   * this is a helpfull option for testing or debugging
   * don't set to true in productiv systems!
   *
   * @var boolean
   */
  protected $disabled = false;

  /**
   * available Access Levels
   * @var array
   */
  protected $levels = [];

  /**
   * Der Datenbank manager
   * @var LibAclManager
   */
  protected $manager = null;

  /**
   * Der ACL Reader
   * @var LibAclReader
   */
  protected $reader = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Messaging System
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibFlowApachemod $env
   */
  public function __construct($env = null  )
  {

    $this->levels = Acl::$accessLevels;

    if (!$env)
      $env = BuizCore::getActive();

    $this->env = $env;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// getter + setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter class for the user object
   * @param boolean $disabled
   */
  public function setDisabled($disabled)
  {
    $this->disabled = $disabled;
  }//end public function setDisabled */

}//end class LibAclAdapter

