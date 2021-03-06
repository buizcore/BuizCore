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
 * Standard Query Objekt zum laden der Benutzer anhand der Rolle
 *
 * @package net.buiz
 */
class LibUserSettings extends LibSettings
{

  public $user = null;


  /**
   *
   * Enter description here ...
   * @param LibDbConnection $db
   * @param User $user
   * @param LibCache_L1Adapter $cache
   */
  public function __construct($db, $user, $cache)
  {
    $this->db = $db;
    $this->user = $user;
    $this->cache = $cache;
  }//end public function __construct */

  /**
   * @param string $key
   * @return TArray
   */
  public function getSetting($key)
  {

    $cKey = null;
    $userId = null;


    $userId = $this->user->getId();
    $cKey = "{$key}-".$userId;

    if (!isset($this->settings[$cKey])) {

      $className = EUserSettingType::getClass($key);

      $sql = <<<SQL
SELECT rowid, jdata from buiz_user_setting where id_user = {$userId} AND type = {$key};
SQL;

      $data = $this->db->select($sql)->get();

      if ($data)
        $setting = new $className($data['jdata'],$data['rowid']);
      else
        $setting = new $className();

      $this->settings[$cKey] = $setting;

    }

    return $this->settings[$cKey];

  }//end public function getSetting */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveSetting($key, $data)
  {

    $this->settings[$key] = $data;

    $jsonString = $data->toJson();

    $id = $data->getId();

    if ($id) {
      $this->db->getOrm()->update('BuizUserSetting', $id, array('jdata'=>$jsonString,'type'=>$key));
    } else {
      $this->db->getOrm()->insert('BuizUserSetting', array(
      	'jdata' => $jsonString,
      	'type' => $key,
      	'id_user' => $this->user->getId()
      ));
    }

  }//end public function saveSetting */
  
  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveNamedMaskSetting($key, $name, $mask, $data)
  {
  
    $orm = $this->db->getOrm();
    $id = $data->getId();
    
    $this->settings[$key.'-'.$mask.'-'.$name.'-'.$id] = $data;
    $jsonString = $data->toJson();
  
    
    $whereVid = is_null($id)?' IS NULL ':' = '.$id;
    
    $sNode = $orm->get(
      'BuizUserSetting',
      "id_user=".$this->user->getId()." AND type=".$key.' and vid '.$whereVid
     );
  
    if ($id) {
      $this->db->getOrm()->update('BuizUserSetting', $id, array('jdata'=>$jsonString,'type'=>$key));
    } else {
      $this->db->getOrm()->insert('BuizUserSetting', array(
          'jdata' => $jsonString,
          'type' => $key,
          'id_user' => $this->user->getId()
      ));
    }
  
  }//end public function saveNamedMaskSetting */

}// end class LibUserSettings

