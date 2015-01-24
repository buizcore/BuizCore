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
class LibVerificationHtaccess extends LibVerificationAdapter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $login
   * @param string $pwd
   * @return boolean
   */
  public function verificate($login , $password = null)
  {

    if ('' == trim($login)) {
      Message::addError(I18n::s('Got no username', 'wbf.message'));

      return false;
    }

    if (!$this->nopwd && '' == trim($password)) {
      Message::addError(I18n::s('Got no password', 'wbf.message'));

      return false;
    }

    if (!$this->dataSource)
      $orm = Db::getOrm();
    else
      $orm = $this->dataSource;

    try {
      if (!$role = $orm->get('BuizRoleUser', " upper(name) = '".strtoupper($login)."' ")) {
        Message::addError(I18n::s('No User with that name', 'wbf.message'));

        return false;
      }
    } catch (LibDb_Exception $exc) {
      return false;
    }

    if ($role->getBoolean('inactive')) {
      Message::addError(I18n::s('This account is inactive', 'wbf.message'));

      return false;
    }

    if ($this->nopwd) {
      return true;
    }

    $dbPwd = $role->getData('password') ;

    if ($dbPwd != $password) {
      Message::addError(I18n::s('Invalid password', 'wbf.message'));

      return false;
    }

    return true;

  }//end public function verificate */

} // end class LibVerificationHtaccess

