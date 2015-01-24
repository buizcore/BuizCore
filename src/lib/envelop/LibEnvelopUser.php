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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 */
class LibEnvelopUser
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $fullName = null;

  /**
   * @var int
   */
  public $userId = null;

  /**
   * @var string
   */
  public $firstName = null;

  /**
   * @var string
   */
  public $lastName = null;

  /**
   * @var string
   */
  public $userName = null;

  /**
   * @var string
   */
  public $passwd = null;

  /**
   * @var string
   */
  public $employee = null;

  /**
   * @var string
   */
  public $description = null;

  /**
   * @var string
   */
  public $profile = null;

  /**
   * @var int
   */
  public $level = null;

  /**
   * @var boolean
   */
  public $inactive = null;

  /**
   * @var boolean
   */
  public $nonCertLogin = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Lists
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $roles = [];

  /**
   * @var array
   */
  public $profiles = [];

  /**
   * @var array
   */
  public $addressItems = [];

  /**
   * @var array
   */
  public $announcementChannels = [];

}//end class LibEnvelopUser

