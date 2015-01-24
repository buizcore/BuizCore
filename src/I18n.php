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
  * Hauptklasse für die Internationalisierung
  * @package net.buiz
  */
class I18n
{

  /**
   * Das Language Objekt
   *
   * @var LibI18nPhp
   */
  private static $defInstance = null;

  /**
   * die Aktive Sprache
   *
   * @var string
   */
  public static $short = 'en';

  /**
   *
   * @var array
   */
  public static $i18nPath = [];

  /**
   * Trenner für das Datum
   * @var string
   */
  public static $dateSeperator = '-';

  /**
   * Format für das Datum
   * @var string
   */
  public static $dateFormat = 'Y-m-d';

  /**
   * Format für Zeiten
   * @var string
   */
  public static $timeFormat = 'H:i:s';

  /**
   * Trenner für Zeiten
   * @var string
   */
  public static $timeSteperator = ':';

  /**
   * Format für Timestamps
   * @var string
   */
  public static $timeStampFormat = 'Y-m-d H:i:s';

  /**
   *
   * @var string
   */
  public static $numberMil = ',';

  /**
   *
   * @var string
   */
  public static $numberDec = '.';

/*////////////////////////////////////////////////////////////////////////////*/
// Singleton Pattern
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * get Instance für Singleton Patter
   * @return LibI18nPhp
   */
  public static function getDefault()
  {

    if (is_null(self::$defInstance)) {
      if ($conf = Conf::get('i18n')) {

        if (isset($conf['type']))
          $classname = 'LibI18n'.$conf['type'];

        else
          $classname = 'LibI18nPhp';

      }

      self::$defInstance = new $classname($conf , true);
    }

    return self::$defInstance;

  }//end public static function getDefault */

  /**
   * @return LibI18nPhp
   * @deprecated use getActive instead
   */
  public static function getInstance()
  {

    if (is_null(self::$defInstance)) {
      if ($conf = Conf::get('i18n')) {

        if (isset($conf['type']))
          $classname = 'LibI18n'.$conf['type'];

        else
          $classname = 'LibI18nPhp';

      }

      self::$defInstance = new $classname($conf , true);
    }

    return self::$defInstance;

  }//end public static function getInstance */

  /**
   * @return LibI18nPhp
   */
  public static function getActive()
  {

    if (is_null(self::$defInstance)) {
      if ($conf = Conf::get('i18n')) {

        if (isset($conf['type']))
          $classname = 'LibI18n'.$conf['type'];

        else
          $classname = 'LibI18nPhp';

      }

      self::$defInstance = new $classname($conf , true);
    }

    return self::$defInstance;

  }//end public static function getActive */

  /**
   * get Instance für Singleton Patter
   * @return LibI18nPhp
   */
  public static function init()
  {

    if (is_null(self::$defInstance)) {
      if ($conf = Conf::get('i18n')) {
        if (isset($conf['type']))
          $classname = 'LibI18n'.$conf['type'];

        else
          $classname = 'LibI18nPhp';
      }

      self::$defInstance = new $classname($conf,true);

    }

  }//end public static function init */

  /**
   *
   * @param string $wechseln der aktiven Sprace
   * @return void
   */
  public static function changeLang($lang)
  {

    if (is_null(self::$defInstance))
      self::init();

    ///TODO FIX the set lang on the Lang Object
    self::$defInstance->setLang($lang,true);

  }//end public static function changeLang */

  /**
   * die Id der Aktuellen Sprache
   *
   * @return int
   */
  public static function getId()
  {
    return BuizCore::getSysStatus('langid');
  }//end public static function getId */

  /**
   *
   */
  public static function writeCache()
  {
    self::$defInstance->saveCache();
  }// end public static function writeCache

  /**
   * ändern des Sprachpaketes das genutzt werden soll
   * @param string $lPackage
   * @return void
   */
  public static function changeLPackage($lPackage)
  {
    if (is_null(self::$defInstance))
      self::init();

    self::$defInstance->setLPackage($lPackage);

  }//end public static function changeLPackage */

  /**
   * statische Internationalisierungs Methode
   * @param string $name
   * @param array $data
   * @return string den internationalisierten String
   */
  public static function s($text, $name = null, $data = [])
  {
    return self::$defInstance->l($text, $name, $data);
  }//end public static function s */

} // end class I18n

