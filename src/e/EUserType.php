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
 * @package net.webfrap
 */
class EUserType
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * Der System Account, gibts nur einmal
   * @var int
   */
  const SYSTEM = 1;
  
  /**
   * @var int
   */
  const USER = 2;

  /**
   * @var int
   */
  const PLUGIN = 3;

  /**
   * @var int
   */
  const ORGANISATION = 4;

  /**
   * @var int
   */
  const BUIZ_NODE =5;

  /**
   * @var int
   */
  const BOT = 6;

  /**
   * @var int
   */
  const SPIDER = 7;

/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var array
    */
    public static $labels = [
        self::SYSTEM => 'System',
        self::USER => 'User',
        self::PLUGIN => 'Pugin',
        self::ORGANISATION => 'Organisation',
        self::BUIZ_NODE => 'BuizNode',
        self::BOT => 'Bot',
        self::SPIDER => 'Spider',
    ];

   /**
    * @param string $key
    * @return string
    */
    public static function label($key)
    {
        $i18n = BuizCore::$env->getI18n();

        return isset(self::$labels[$key])
          ? $i18n->l(self::$labels[$key],'wbfsys.base')
          : null; // sollte nicht passieren
    
    }//end public static function label */


}//end class EUserType

