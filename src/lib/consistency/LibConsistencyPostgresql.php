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
class LibConsistencyPostgresql
{

  /**
   * @var LibDbConnection
   */
  public $db;

  /**
   * @var LibResponseHttp
   */
  public $response = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibDbConnection $db
   * @param LibResponseHttp $response
   */
  public function __construct($db, $response)
  {

    $this->db = $db;
    $this->response = $response;

  }//end public function __construct */

  /**
   *
   */
  public function cleanByEntity()
  {

  }//end public function cleanByEntity */

}//end class LibDeveloperClassindexer

