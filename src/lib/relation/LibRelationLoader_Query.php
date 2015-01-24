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
class LibRelationLoader_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessage_Receiver_Group $group
   * @param string $type
   */
  public function fetchGroups($group  )
  {

    $areas = [];
    $id = null;

    if ($group->area) {
      $areas = $this->extractWeightedKeys($group->area);
    }

    if ($group->entity) {
      if (is_object($group->entity)) {
        $id = $group->entity->getId();
      } else {
        $id = $group->entity;
      }
    }

    $joins = '';

    // wenn keine Area übergeben wurde dann brauchen wir nur die
    // globalen assignments
    if ($id) {
      $areaKeys = " buiz_security_area.access_key  IN('".implode("', '",$areas)."') " ;

      $joins = <<<SQL

  JOIN
    buiz_group_users
    ON
      buiz_group_users.id_user = buiz_role_user.rowid

  JOIN
    buiz_security_area
    ON
    (
      CASE WHEN
       buiz_group_users.id_area IS NOT NULL
       THEN
       (
         CASE WHEN
          buiz_group_users.vid IS NOT NULL
           THEN
             buiz_group_users.id_user = buiz_role_user.rowid
               and buiz_group_users.id_area = buiz_security_area.rowid
               and {$areaKeys}
               and buiz_group_users.vid = {$id}
           ELSE
             buiz_group_users.id_user = buiz_role_user.rowid
               and buiz_group_users.id_area = buiz_security_area.rowid
               and {$areaKeys}
               and buiz_group_users.vid is null
         END
       )
       ELSE
         buiz_group_users.id_user = buiz_role_user.rowid
           and buiz_group_users.id_area is null
           and buiz_group_users.vid is null
       END
    )

SQL;


    } elseif ($areas) {
      $areaKeys = " buiz_security_area.access_key  IN('".implode($areas,"','")."')" ;

      $joins = <<<SQL

  JOIN
    buiz_group_users
    ON
      buiz_group_users.id_user = buiz_role_user.rowid

  JOIN
    buiz_security_area
    ON
    (
      CASE
      WHEN
       buiz_group_users.id_area IS NOT NULL
        THEN
          buiz_group_users.id_user = buiz_role_user.rowid
            and buiz_group_users.id_area = buiz_security_area.rowid
            and {$areaKeys}
            and buiz_group_users.vid is null
        ELSE
         buiz_group_users.id_user = buiz_role_user.rowid
           and buiz_group_users.id_area is null
           and buiz_group_users.vid is null
      END
    )

SQL;


    } else {

      // buiz_security_area.rowid = buiz_role_group.id_area
      $joins = <<<SQL

  JOIN
    buiz_group_users
    ON
      buiz_group_users.id_user = buiz_role_user.rowid
        and buiz_group_users.id_area  is null
        and buiz_group_users.vid      is null
SQL;

    }

    if (is_array($group->name)) {
      $groupRoles = " IN('".implode($group->name,"','")."')" ;
    } else {
      $groupRoles = " =  '{$group->name}' " ;
    }


    $query = <<<SQL

SELECT
  distinct buiz_role_user.rowid as userid,
  buiz_role_user.name,
  core_person.salutation,
  core_person.firstname,
  core_person.second_firstname,
  core_person.lastname,
  core_person.academic_title

FROM
  buiz_role_user

{$joins}
  JOIN
    buiz_role_group
      ON buiz_role_group.rowid = buiz_group_users.id_group

  JOIN
    core_person
    ON
      buiz_role_user.id_person = core_person.rowid

WHERE
  buiz_role_group.access_key {$groupRoles}
    AND ( buiz_group_users.partial = 0 )
    AND
      NOT buiz_role_user.inactive = TRUE

SQL;


    $db = $this->getDb();

    return $db->select($query)->getAll();

  }//end public function fetchGroups */

  /**
   * @param LibMessage_Receiver_User $user
   * @param string $type
   */
  public function fetchUser($user)
  {

    if ($user->user) {

      if (!$user->user->id_person) {
        throw new LibMessage_Exception('Invalid Userobject '. $user->user->name .', missing person ID');
      }

      $sql = <<<SQL

SELECT
  core_person.salutation,
  core_person.firstname,
  core_person.second_firstname,
  core_person.lastname,
  core_person.academic_title,
  buiz_role_user.name

FROM
  core_person

JOIN
  buiz_role_user
  ON
    buiz_role_user.id_person = core_person.rowid

WHERE
  buiz_role_user.rowid = {$user->user}
  	AND  NOT buiz_role_user.inactive = TRUE


SQL;

    } elseif ($user->id) {

      $sql = <<<SQL

SELECT
  core_person.salutation,
  core_person.firstname,
  core_person.second_firstname,
  core_person.lastname,
  core_person.academic_title,
  buiz_role_user.name

FROM
  core_person

JOIN
  buiz_role_user
  ON
    buiz_role_user.id_person = core_person.rowid

WHERE
  buiz_role_user.rowid = {$user->id}
  	AND  NOT buiz_role_user.inactive = TRUE

SQL;

    } elseif ($user->name) {

      $sql = <<<SQL

SELECT
  core_person.salutation,
  core_person.firstname,
  core_person.second_firstname,
  core_person.lastname,
  core_person.academic_title,
  buiz_role_user.name

FROM
  core_person

JOIN
  buiz_role_user
  ON
    buiz_role_user.id_person = core_person.rowid

WHERE
  UPPER(buiz_role_user.name) = UPPER('{$user->name}')
  AND  NOT buiz_role_user.inactive = TRUE

SQL;

    } else {
      Debug::console('Receiver for User: '.$user->name.' '.$user->id.' was empty',$user);
      throw new LibRelation_Exception('Receiver for User: '.$user->name.' '.$user->id.' was empty');
    }

    $db = $this->getDb();

    $userData = $db->select($sql)->get();

    Debug::console($sql, $userData);

    return $userData;

  }//end public function fetchUser */

  /**
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $keys
   * @return array
   */
  protected function extractWeightedKeys($keys)
  {

    $keysData = [];

    $tmp = explode('>', $keys);

    $areas = explode('/', $tmp[0]);

    $wAreas = [];
    if (isset($tmp[1]))
      $wAreas = explode('/', $tmp[1]);;

    $keysData = array_merge($areas, $wAreas);

    return $keysData;

  }//end protected function extractWeightedKeys */

} // end class LibMessageGrouploader_Query

