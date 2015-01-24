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
class LibDbAdminMysql
{
  /**
   *
   * @var LibDbConnectionMysql
   */
  protected $db = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   */
  public function getDatabases()
  {

    $sql = <<<SQL
  SELECT SCHEMA_NAME as name,  DEFAULT_CHARACTER_SET_NAME as charset FROM  SCHEMATA;
SQL;

    return $this->db->select($sql)->getAll();


  }//end public function getDatabases */

  /**
   */
  public function getDbTables($dbName  )
  {

    $sql = <<<SQL
  SELECT TABLE_NAME as name,  TABLE_COLLATION as encoding, TABLE_COMMENT as comment FROM  TABLES where TABLE_SCHEMA = '$dbName';
SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getDatabases */

  public function getTableQuotes($dbName , $table  )
  {

    $quotes = array
    (
      'varchar' => true,
      'bigint' => false,
      'longtext' => true,
      'decimal' => false,
      'datetime' => true,
      'int' => false,
      'integer' => false,
      'timestamp' => true,
      'char' => true,
      'date' => true,
      'text' => true,
      'tinyint' => false,
      'smallint' => false,
      'longblob' => true,
      'mediumtext' => true,
      'mediumint' => true,
      'set' => true,
      'enum' => true,
      'blob' => true,
      'year' => true,
    );

    $sql = <<<SQL
  SELECT COLUMN_NAME as name,  DATA_TYPE as type  FROM  COLUMNS
    where TABLE_SCHEMA = '$dbName'
    and TABLE_NAME = '$table' ;

SQL;

    $results = $this->db->select($sql)->getAll();

    $meta = [];

    foreach ($results as $row)
      $meta[$row['name']] = $quotes[$row['type']];

    return $meta;

  }//end public function getTableQuotes */

} // end class LibDbAdminMysql
