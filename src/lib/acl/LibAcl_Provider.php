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
class LibAcl_Provider extends LibAclBase_Provider
{

    /**
     * @param int $userId
     * @param [] $roles
     */
    public function getGlobalRoles($userId, $roles)
    {
        
        $db = $this->getDb();
        
        $roleKeys = $this->keysToQuery($roles);

        $sql = <<<SQL
SELECT 
    gu.id_group,
    group.access_key
FROM 
    buiz_group_users gu
JOIN
    buiz_role_group group
        ON group.rowid =  gu.id_group
WHERE
      partial = 0 AND id_user = {$userId} and UPPER(group.access_key) IN({$roleKeys});
    
SQL;
        
        $result = $db->select($sql)->getAll();
        
        $groups = [];
        foreach($result as $row){
            $groups[$row['access_key']] = $row['id_group'];
        }
        
        return $groups;

	}//end public function getGlobalRoles */



}//end class LibAcl_Provider

