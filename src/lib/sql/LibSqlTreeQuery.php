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
 * Collection to fetch result and bundle them
 *
 * @package net.buiz
 */
abstract class LibSqlTreeQuery extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $childs = [];

  /**
   * @var array
   */
  public $data = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Magic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $condition
   * @param LibDbConnection $db
   */
  public function __construct($condition = null, $db = null)
  {
    if (!is_null($condition))
      $this->condition = $condition;

    $this->db = $db;

    if (DEBUG)
      Debug::console('Created new tree query '.get_class($this));

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Tree Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   * @param string $key
   * @return array
   */
  public function getNodeChildren($key)
  {

    if (isset($this->childs[$key])) {
      return $this->childs[$key];
    } else {
      return null;
    }

  }//end public function getNodeChildren */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function clean()
  {
    $this->data = [];
    $this->childs = [];
    $this->result = null;
    $this->sourceSize = null;
  }//end public function clean */

  /**
   * get the size of the last query
   * @return int
   */
  public function getSize()
  {
     return $this->result->count();
  }//end public function getSize */

  /**
   * get the size of the last query that should have been given back
   * if there was no offset and no limit
   *
   * @return int
   */
  public function getSourceSize()
  {

    if (is_null($this->sourceSize)) {
      if (!$this->calcQuery)
        return null;

      if (is_string($this->calcQuery)) {
        if ($res = $this->getDb()->select($this->calcQuery)) {
          $tmp = $res->get();
          $this->sourceSize = $tmp[Db::Q_SIZE];
        }
      } else {
        if ($res = $this->getDb()->getOrm()->select($this->calcQuery)) {
          $tmp =  $res->get();
          $this->sourceSize = $tmp[Db::Q_SIZE];
        }
      }

    }

    return $this->sourceSize;

  }//end public function getSourceSize */

  /**
   * request one single row from the database
   *
   * @return array
   */
  public function get()
  {
    $val = current($this->data);
    next($this->data);

    return $val;
  }//end public function get */

  /**
   * fetch all rows from the database
   * @return array
   */
  public function getAll()
  {
    return $this->data;
  }//end public function getAll */

  /**
   * load the data an store it
   * @return array
   */
  public function load()
  {

  }//end public function loadData */

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: Iterator
/*////////////////////////////////////////////////////////////////////////////*/

  ///TODO Checken ob das wieder korrekt umgestellt werden kann

  /**
   */
  public function current ()
  {
    return current($this->data);

  }//end public function current */

  /**
   */
  public function key ()
  {
    return key($this->data);
  }//end public function key */

  /**
   */
  public function next ()
  {
    return next($this->data);
  }//end public function next */

  /**
   */
  public function rewind ()
  {
    return reset($this->data);
  }//end public function rewind */

  /**
   */
  public function valid ()
  {
    return current($this->data)? true:false;

  }//end public function valid */

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: Countable
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function count()
  {
    return count($this->data);

  }//end public function count */

}//end abstract class LibSqlTreeQuery
