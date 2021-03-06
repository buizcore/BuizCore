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
 *
 * @package net.buiz
 * @author Dominik Donsch <dominik.bonsch@buiz.net>
 *
 */
class LibProcess_Edge
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $order = null;

  /**
   * @var string
   */
  public $confirm = false;

  /**
   * @var string
   */
  public $icon = null;

  /**
   * @var string
   */
  public $color = null;

  /**
   * @var string
   */
  public $description = null;

  /**
   * Der Key des Knoten
   * @var string
   */
  public $key = null;

  /**
   * @var string
   */
  public $hasRoles = [];

  /**
   * @var array
   */
  public $roles = [];

  /**
   * @var array
   */
  public $profiles = [];

  /**
   * @var array
   */
  public $access = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Standard Konstruktor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param array $nodeData
   */
  public function __construct($key, array $nodeData)
  {

    $this->key = $key;

    $this->label = $nodeData['label'];
    $this->order = $nodeData['order'];

    $this->icon = isset($nodeData['icon'])
      ? $nodeData['icon']
      : 'process/go_on.png';

    $this->color = isset($nodeData['color'])
      ? $nodeData['color']
      : 'default';

    $this->description = isset($nodeData['description'])
      ? $nodeData['description']
      : '';

    $this->profiles = isset($nodeData['profiles'])
      ? $nodeData['profiles']
      : [];

    $this->roles = isset($nodeData['roles'])
      ? $nodeData['roles']
      : [];

    $this->hasRoles = isset($nodeData['has_roles'])
      ? $nodeData['has_roles']
      : [];

    $this->access = isset($nodeData['access'])
      ? $nodeData['access']
      : [];

    $this->confirm = isset($nodeData['confirm'])
      ? $nodeData['confirm']
      : false;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// check methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function getRoles()
  {
    return $this->roles;
  }//end public function getRoles */

  /**
   * @return array
   */
  public function getRolesSomewhere()
  {
    return $this->hasRoles;

  }//end public function getRolesSomewhere */

  /**
   * Prüfen ob die Edge im aktuellen Profil des Benutzers sichtbar sein soll
   *
   * @param string $key Der Name des Profils
   * @param boolean $force erzwingen, dass Profile vorhanden sein müssen
   * @return boolean
   */
  public function hasProfile($key, $force = false)
  {

    if (!$force && empty($this->profiles))
      return true;

    return in_array($key, $this->profiles);

  }//end public function hasProfile */

  /**
   * @param string|array $key
   * @return boolean
   */
  public function hasAccess($key)
  {

    if (empty($this->access))
      return false;

    if (is_array($key)) {

      foreach ($key as $accessKey) {
        if (in_array($accessKey, $this->access))
          return true;
      }

      return false;

    } else {
      return in_array($key, $this->access);
    }

  }//end public function hasAccess */

  /**
   * @return array
   */
  public function getAccess()
  {
    return $this->access;
  }//end public function getAccess */

/*////////////////////////////////////////////////////////////////////////////*/
// Debug Data
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Methode zum bereitstellen notwendiger Debugdaten
   * Sinn ist es möglichst effizient den aufgetretenen Fehler lokalisieren zu
   * können.
   * Daher sollte beim implementieren dieser Methode auch wirklich nachgedacht
   * werden.
   * Eine schlechte debugData Methode ist tendenziell eher schädlich.
   *
   * @return string
   */
  public function debugData()
  {
    return 'Process Edge key: '.$this->key.' Label: '.$this->label;

  }//end public function debugData */

}//end class LibProcess_Edge

