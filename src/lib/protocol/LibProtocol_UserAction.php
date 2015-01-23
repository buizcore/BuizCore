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
 * Ausgeführte Aktionen protokollieren
 * @package net.webfrap
 *
 */
class LibProtocol_UserAction
{

  private $orm = null;

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct($orm)
  {

    $this->orm = $orm;

  } // end public function __construct */

  /**
   * @param string $message
   * @param string $area
   * @param Entity $entity
   */
  public function write($message, $area = null, $entity = null)
  {
    
    $vid = null;
    $idEntity = null;

    $this->orm->insert(
      'WbfsysActionLog',
      array(
        'content' => $message,
        'vid' => $vid,
        'id_vid_entity' => $idEntity,
      )
    );

  } // end public function __destruct */

} // end LibProtocol_UserAction

