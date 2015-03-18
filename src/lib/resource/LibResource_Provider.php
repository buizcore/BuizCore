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
class LibResource_Provider extends Provider
{

  /**
   * @var var LibResource_Provider
   */
  private static $default = null;

  /**
   * @var LibCacheMemcache
   */
  protected $rCache = null;

  /**
   * @return LibResource_Provider
   */
  public static function getDefault()
  {

    if(!self::$default)
      self::$default = new LibResource_Provider(BuizCore::$env);

    return self::$default;

  } //end public static function getDefault */


  /**
   * @var $env LibFlow
   */
  public function __construct($env=null)
  {

    $this->env = $env?:BuizCore::$env;
    $this->rCache = $this->env->getL1Cache();

  }//end public function __construct */

  /**
   * @param string $key
   * @return int
   */
  public function getAreaId($key)
  {

    $areaId = $this->rCache->get('areaid-'.$key);

    if (!$areaId) {

      $db = $this->getDb();
      $sql = <<<SQL
select rowid from buiz_security_area where access_key = '{$db->escape($key)}';
SQL;
      $areaId = $db->select($sql)->getField('rowid');

      if ($areaId) {
        $this->rCache->add('areaid-'.$key, $areaId);
      } else {
        Log::error('Missing the AreaId for key: '.$key);
      }

      // has a value or is null
      return $areaId;

    } else {

      return $areaId;
    }

  }//end public function getAreaId */

  /**
   * @param [string] $keys
   * @return [int]
   */
  public function getAreaIds($keys)
  {

    $areaIds = [];

    foreach ($keys as $key) {

      $areaId = $this->get('areaid-'.$key);

      if ($areaId)
       $areaIds[$key] = $areaId;
    }

    return $areaIds;

  }//end public function getAreaIds */

  /**
   * @param string $key
   * @return int
   */
  public function getGroupId($key)
  {

    $groupId = $this->rCache->get('group-'.$key);

    if (!$groupId) {

      $db = $this->getDb();
      $sql = <<<SQL
select rowid from buiz_role_group where access_key = '{$db->escape($key)}';
SQL;
      $groupId = $db->select($sql)->getField('rowid');

      if ($groupId)
        $this->rCache->add('group-'.$key, $groupId);

      // has a value or is null
      return $groupId;

    } else {

      return $groupId;
    }

  }//end public function getGroupId */

  /**
   * @param [string] $keys
   * @return [int]
   */
  public function getGroupIds($keys)
  {

    $groupIds = [];

    foreach ($keys as $key) {

      $groupId = $this->rCache->get('group-'.$key);
      if ($groupId)
        $groupIds[$key] = $groupId;
    }

    return $groupIds;

  }//end public function getGroupIds */

} // end class LibResource_Provider

