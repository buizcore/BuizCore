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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class LibCleanerUser
{

  private static $default = null;

  /**
   * @return LibCleanerDset
   */
  public static function getDefault()
  {

    if (!self::$default)
      self::$default = new LibCleanerUser();

    return self::$default;

  }//end public static function getDefault */

  /**
   * Löschen aller möglicherweise vorhandenen vid links
   *
   * @param LibDbConnection $db
   * @param int $id
   */
  public function cleanDefault($db, $id)
  {

    if (is_object($id) && $id instanceof Entity)
      $id = $id->getId();

    if (!ctype_digit($id) || ! (int) $id > 0) {

      $userMsg = <<<ERRMSG
Sorry, there was a
ERRMSG;

      $devMsg = <<<ERRMSG
Tried
ERRMSG;

      throw new Io_Exception($userMsg, $devMsg);
    }

    $sql = [];

    // bookmarks
    $sql[] = <<<SQL
DELETE FROM buiz_bookmark where vid = {$id};
SQL;

    // calendar refs
    $sql[] = <<<SQL
DELETE FROM buiz_calendar_vref where vid = {$id};
SQL;

    // calendar refs
    $sql[] = <<<SQL
DELETE FROM buiz_tag_reference where vid = {$id};
SQL;

    // comments
    $sql[] = <<<SQL
DELETE FROM buiz_comment where vid = {$id};
SQL;

    // faq
    $sql[] = <<<SQL
DELETE FROM buiz_faq where vid = {$id};
SQL;


    // Prozess status leeren
    $sql[] = <<<SQL
DELETE FROM buiz_process_status where vid = {$id};
SQL;

    $db->multiDelete($sql);

  }//end public function cleanDefault */

} // end class LibCleanerDb

