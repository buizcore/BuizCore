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

// include password compat lib if not exists
if(!function_exists('password_hash')){
    include PATH_ROOT.'BuizCore_Vendor/vendor/password/password.php';
}

/**
 * @package net.buiz
 */
class SEncrypt
{

  /**
   * wrapper method for password encryption
   *
   * @param string $value
   * @return string sha1 hash
   */
  public static function passwordHash($value, $mainSalt = '', $dynSalt = '')
  {
    //return sha1($mainSalt.$dynSalt.$value);
    return password_hash($mainSalt.$dynSalt.$value, PASSWORD_BCRYPT, array("cost" => 10));
    
  }//end public static function passwordHash */
  
  /**
   * wrapper method for password encryption
   *
   * @param string $password
   * @return string $hash
   */
  public static function passwordVerify($password, $hash)
  {
      //return sha1($mainSalt.$dynSalt.$value);
      return password_verify($password, $hash);
  
  }//end public static function passwordVerify */

  /**
   * @return string
   */
  public static function createSalt($size = 10)
  {
    return substr(uniqid(mt_rand(), true),  0, $size);

  }//end public static function createSalt */

  /**
   * @return string
   */
  public static function uniqueToken($size = 12)
  {
    return substr(uniqid(mt_rand(), true),  0, $size  );

  }//end public static function uniqueToken */

}// end SEncrypt

