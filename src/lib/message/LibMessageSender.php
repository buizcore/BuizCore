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
 */
class LibMessageSender
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Id des User Objekts
   * @var int
   */
  public $userId = null;

  /**
   * @var string
   */
  public $userName = null;

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
  public $fullName = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param User $user
   */
  public function __construct($user)
  {

    if ($user instanceof User) {

      $data = $user->getData();

      $this->userId = $user->getId();
      $this->userName = $user->getLoginName();
      $this->firstName = $data['firstname'];
      $this->lastName = $data['lastname'];
      $this->fullName = $user->getFullName();
      
    } else {

      //$orm = BuizCore::$env->getOrm();

      $person = $user->followLink('id_person');

      $this->userId = $user->getId();
      $this->userName = $user->name;
      $this->firstName = $person->firstname;
      $this->lastName = $person->lastname;
      $this->fullName = $person->lastname.", ".$person->firstname;

    }

  }//end public function __construct */

} // end class LibMessageSender

