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
 * Container für url methoden
 * @package net.buiz
 */
final class SUrl
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /**
   * Extrahieren der ACL Teile der URL zusammebauen zu einem
   * validen ACL Url String
   * @param Context $params
   * @return string
   */
  public static function buildAcl($params)
  {

    $urlPart = '';

    // startpunkt des pfades für die acls
    if ($params->aclRoot)
      $urlPart .= '&amp;a_root='.$params->aclRoot;

    if ($params->maskRoot)
      $urlPart .= '&amp;m_root='.$param->maskRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($param->aclRootId)
      $urlPart .= '&amp;a_root_id='.$param->aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($param->aclKey)
      $urlPart .= '&amp;a_key='.$param->aclKey;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($param->aclLevel)
      $urlPart .= '&amp;a_level='.$param->aclLevel;

    // der neue knoten
    if ($param->aclNode)
      $urlPart .= '&amp;a_node='.$param->aclNode;

    return $urlPart;

  }//end public static function buildAcl */

}// end final class SUrl

