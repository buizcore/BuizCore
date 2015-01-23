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
class ERelevance
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const LOW = 1;

  /**
   * @var int
   */
  const AVERAGE = 2;

  /**
   * @var int
   */
  const HIGH = 3;
  
  /**
   * @var array
   */
  public static $labels = array(
    self::LOW => 'Low',
    self::AVERAGE=> 'Average',
    self::HIGH => 'High',
  );

    /**
    * @param string $key
    * @return string
    */
    public static function label($key)
    {
      
        $i18n = BuizCore::$env->getI18n();
        
        return isset(self::$labels[$key])
            ? $i18n->l(self::$labels[$key],'wbfsys.base')
            : $i18n->l(self::$labels[self::AVERAGE],'wbfsys.base');
    
    }//end public static function label */

}//end class ERelevance

