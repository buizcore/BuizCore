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
 * @package net.buiz/cache
 */
class LibCacheDummy extends LibCache_L1Adapter
{

  public $type = 'dummy';

  /**
   * Der Standard Konstruktor zum Initialisieren des Systems
   * @param array $conf
   *  - host:
   *  - port
   */
  public function __construct($conf)
  {

  } // end public function __construct */

  /**
   *
   */
  public function __destruct()
  {

  }//end public function __destruct()

  /**
   * Testen ob ein bestimmter Wert im cache Vorhanden ist
   *
   * @param string Name Name auf des zu testenden Ojektes
   * @param string Area Name der zu löschenden Subarea
   * @return bool
   */
  public function isIncache($name,  $area = null)
  {

    return false;

  } // end public function isIncache

  /**
   * Testen ob noch genug Platz im cache ist
   *
   * @return bool
   */
  public function enoughFree()
  {
    return true;

  } // end public function enoughFree */

  /**
   * Neune Eintrag in den cache werfen
   *
   * @param string Name Name des neuen Objektes
   * @param string Data Die neuen Daten
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function add($name,  $data,  $area = null , $offset = null)
  {

    return false;

  } // end public function add */

  /**
   * Einen bestimmten Wert im cache updaten bzw ersetzen
   *
   * @param string $key Name des zu ersetzenden Datensatzes
   * @param string $data Der neue Datensatz
   * @return bool
   */
  public function replace($key, $data, $subKey = null  )
  {

    return false;

  } // end public function replace */

  /**
   * Ein Objekt aus dem cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem cache
   * @param string Area Die zu verwendente Subarea
   * @return string
   */
  public function get($name,  $area = null)
  {

    return false;

  } // end public function get */

  /**
   * Ein Objekt aus dem cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function delete($name,  $area = null)
  {

    return true;

  } // end public function delete */

  /**
   * Incrementieren eines Wertes im cache
   *
   * @param string Name Name des Objekts das aus dem cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function increment($name,  $area = null)
  {

    return false;

  }// end public function increment */

  /**
   * Decrementieren eines Wertes im cache
   *
   * @param string Name Name des Objekts das aus dem cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function decrement( $name,  $area = null  )
  {

    return false;

  }// end public function decrement */

  /**
   * Den cache komplett leeren
   *
   * @return bool
   */
  public function cacheClean()
  {

    return true;

  } // end public function cacheClean */



  /* (non-PHPdoc)
   * @see LibCacheAdapter::exists()
   */
  public function exists($key)
  {
    // TODO Auto-generated method stub

  }

  /* (non-PHPdoc)
   * @see LibCacheAdapter::remove()
   */
  public function remove($key)
  {
    // TODO Auto-generated method stub

  }

 /* (non-PHPdoc)
   * @see LibCacheAdapter::clean()
   */
  public function clean()
  {
    // TODO Auto-generated method stub

  }


} // end class LibCacheDummy

