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
 * @lang de:
 *
 * Der Datenbank Adapter für die ACLs
 *
 * @package net.buiz
 *
 * @todo die queries müssen noch in query objekte ausgelagert werden
 *
 */
class LibAclBase_Provider extends Manager
{

    /**
    * @param string $key
    * @return int
    */
    public function getAreaId($key)
    {
      
        $cache = $this->getL1Cache();

        $areaId = $cache->get('secarea-'.$key);

        if (!$areaId) {

            $db = $this->getDb();
            $sql = <<<SQL
select rowid from buiz_security_area where access_key = '{$db->escape($key)}';
SQL;
            $areaId = $db->select($sql)->getField('rowid');

            if ($areaId) {
                $cache->add('secarea-'.$key, $areaId);
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
        $cache = $this->getL1Cache();
    
        $areaIds = [];
        
        foreach ($keys as $key) {
        
            $areaId = $cache->get('secarea-'.$key);
            
            if ($areaId) {
                
                $areaIds[$key] = $areaId;
                
            } else {
                
                $areaId = $this->getAreaId($key);
                
                if ($areaId) {
                    $areaIds[$key] = $areaId;
                }
                
            }
        }
        
        return $areaIds;
    
    }//end public function getAreaIds */

    /**
    * @param string $key
    * @return int
    */
    public function getGroupId($key)
    {
      
        $cache = $this->getL1Cache();

        $groupId = $cache->get('group-'.$key);

        if (!$groupId) {

            $db = $this->getDb();
            $sql = <<<SQL
select rowid from buiz_role_group where access_key = '{$db->escape($key)}';
SQL;
            $groupId = $db->select($sql)->getField('rowid');

            if ($groupId)
                $cache->add('group-'.$key, $groupId);

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
        
        $cache = $this->getL1Cache();
    
        $groupIds = [];
        
        foreach ($keys as $key) {
        
            $groupId = $cache->get('group-'.$key);
          
            if ($groupId) {
                $groupIds[$key] = $groupId;
            } else {
                $groupId = $this->getGroupId($key);
                
                if ($groupId) {
                    $groupIds[$key] = $groupId;
                }
            }
        }
        
        return $groupIds;
    
    }//end public function getGroupIds */

    /**
     * @param [string] $keys
     * @return string
     */
    public function keysToQuery($keys)
    {
    
        return " UPPER(".implode($keys,"'), UPPER('")."') ";
 
    }//end public function keysToQuery */

}//end class LibAclBase_Provider

