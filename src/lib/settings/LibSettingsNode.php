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
class LibSettingsNode
{

  /**
   * der Rootnode der Settings
   * @var stdClass
   */
  protected $id = null;

  /**
   * der Rootnode der Settings
   * @var stdClass
   */
  protected $node = null;

  /**
   * Flag zum feststellen ob die Settings geändert wurden, also ob
   * sie zurückgeschrieben werden müssen
   *
   * @var boolean
   */
  public $changed = false;

  /**
   * @param string $jsonData
   * @param int $id
   */
  public function __construct($jsonData = null, $id = null)
  {

    if (!is_null($jsonData))
      $this->node = json_decode($jsonData);
    else
      $this->node = new stdClass();

    $this->id = $id;

    Log::debug("GOT ID ".$id);

    $this->prepareSettings();

  }//end public function __construct */


  /**
   * @param string $key
   * @param string $value
   */
  public function __set($key, $value)
  {

    if (!isset($this->node->{$key}) || $this->node->{$key} !== $value)
      $this->changed = true;

    $this->node->{$key} = $value;

  }//end public function __set */

  /**
   * @param string $key
   */
  public function __get($key)
  {

    return isset($this->node->{$key})
      ? $this->node->{$key}
      : null;

  }//end public function __get */

  /**
   * @return int
   */
  public function getId()
  {

    return $this->id;

  }//end public function getId */

  /**
   * @return int
   */
  public function setId($id)
  {

    $this->id = $id;

  }//end public function setId */

  /**
   * Den Settingsnode as json String serialisieren
   */
  public function toJson()
  {

    return json_encode($this->node);

  }//end public function toJson */


  /**
   * Prepare the settings
   */
  protected function prepareSettings()
  {
    // kann, muss aber nicht implementiert werden daher einfach leer
  }//end protected function prepareSettings */

}// end class LibSettingsNode

