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
 * Login aus der Url Auslesen
 * Nicht unbedingt schön, aber manchmal nicht zu vermeiden
 *
 * @package net.buiz
 */
class LibAuthHttpget extends LibAuthApdapter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen ob es Authdata gibt
   * @return boolean
   */
  public function authDataAvailable()
  {

    if ($this->httpRequest)
      $httpRequest = $this->httpRequest;
    else
      $httpRequest = Request::getActive();

    if (!$httpRequest->paramExists('name'))
      return false;

    if (!$httpRequest->paramExists('passwd'))
      return false;

    return true;

  } //end public function authDataAvailable */

  /**
   * @param LibAuth $data
   * @return LibAuth
   */
  public function fetchLoginData($authobj)
  {

    if ($this->httpRequest)
      $httpRequest = $this->httpRequest;
    else
      $httpRequest = Request::getActive();

    $username = $httpRequest->param('name'    , Validator::TEXT      );
    $password = $httpRequest->param('passwd'  , Validator::TEXT  );

    // if one of both is empty
    if (!$username || !$password)
      return false;

    $authobj->setUsername($username);
    $authobj->setPassword($password);

    return true;

  }//end public function fetchLoginData */

} // end class LibAuthHttppost

