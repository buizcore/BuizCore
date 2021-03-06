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
class Protocol extends BaseChild
{

  /**
   * @var Protocol
   */
  private static $default = null;

  /**
   * @return Protocol
   */
  public static function getDefault()
  {

    if (!self::$default) {
      self::$default = new Protocol();
      self::$default->setEnv(BuizCore::$env  );
    }

    return self::$default;

  }//end public function getDefault *

  /**
   * @param string $mask
   * @param Entity $entity
   */
  public function updateLastVisited($mask, $entity, $label  )
  {

    $db = $this->getDb();
    $orm = $db->orm;
    $user = $this->getUser();

    if (is_array($entity)) {
      $resourceId = $orm->getResourceId($entity[0]);
      $entityId = $entity[1];
    } elseif (is_string($entity)) {
      $resourceId = $orm->getResourceId($entity);
      $entityId = null;
    } else {
      $resourceId = $orm->getResourceId($entity);
      $entityId = $entity->getId();
    }

    if (!$resourceId) {

      Log::warn("Got no Resource ID, this means the datamodell is not yet synced.");
      return;
    }

    if ($entityId) {
      $codeVid = " = {$entityId}";
      $valVid = "{$entityId}";
    } else {
      $codeVid = " IS NULL";
      $valVid = "NULL";
    }

    $maskId = $this->getMaskId($mask);

    $createDate = date("Y-m-d H:i:s");

    $label = $db->escape($label);

    $sql = <<<SQL

UPDATE buiz_protocol_access
SET
  counter = counter +1,
   m_time_created = '{$createDate}',
   label = '{$label}'
WHERE
  id_mask = '{$maskId}'
  AND id_vid_entity = {$resourceId}
  AND vid {$codeVid}
  AND m_role_created = {$user->getId()};

SQL;

    $db->exec($sql);

    if (!$db->getAffectedRows()) {
      $sql = <<<SQL

INSERT INTO buiz_protocol_access
(
  id_mask,
  counter,
  id_vid_entity,
  vid,
  label,
  m_role_created,
  m_time_created
)
VALUES
(
  '{$maskId}',
  1,
  {$resourceId},
  {$valVid},
  '{$label}',
  {$user->getId()},
  '{$createDate}'
);

SQL;

      $db->exec($sql);
    }

  }//end public function updateLastVisited */

  /**
   * @param string $maskKey
   * @return int
   */
  public function getMaskId($maskKey)
  {

    $orm = $this->getOrm();

    // checken ob wir einen level 1 cache haben
    $cache = $this->getL1Cache();

    if ($cache) {
      $mId = $cache->get('wbfmask-'.$maskKey);

      if ($mId)
        return $mId;
    }

    $id = $orm->getIdByKey('BuizMask', $maskKey);

    if ($id) {

      if ($cache) {
        $cache->add('wbfmask-'.$maskKey, $id);
      }

      return $id;
    }

    $mask = $orm->newEntity('BuizMask');
    $mask->access_key = $maskKey;
    $mask->name = SParserString::subToName($maskKey);
    $orm->insert($mask);

    $id = $mask->getId();
    if ($cache) {
      $cache->add('wbfmask-'.$maskKey, $id);
    }

    return $id;

  }//end public function getMaskId */

} // end class Protocol

