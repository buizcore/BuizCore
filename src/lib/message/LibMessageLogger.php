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
class LibMessageLogger
{
/*////////////////////////////////////////////////////////////////////////////*/
// Wichtige Resoucen
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   *
   * @var User
   */
  protected $user = null;

/*////////////////////////////////////////////////////////////////////////////*/
// getter + setter für die Resourcen
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibDbConnection $db
   */
  public function getDb()
  {

    if (!$this->db)
      $this->db = BuizCore::$env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @param LibDbConnection $db
   */
  public function setDb($db)
  {
    $this->db = $db;
  }//end public function setDb */

  /**
   * @param LibDbConnection $db
   * @param User $user
   */
  public function __construct($db, $user)
  {
    
    $this->db = $db;
    $this->user = $user;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $address
   * @param string $title
   */
  public function logMessage($address, $title, $success = true)
  {
    
    $this->db->orm->insert(
      'WbfsysMessageLog',
      array(
        'title' => $title,
        'email' => $address,
        'success' => ($success?'t':'f')
      )
    );

  }//end public function logMessage */

}// end LibMessageLogger

