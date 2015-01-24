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
class EUserRelation
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Gehört zu uns
    * @var int
    */
    const INTERNAL = 1;
    
    /**
    * Gehört zu einerm unserer Partner
    * @var int
    */
    const PARTNER = 2;
    
    /**
    * Ist uns bekannt (z.B ein guter Kunde)
    * @var int
    */
    const CUSTOMER = 3;
    
    /**
    * Jemand der sich angemeldet hat (z.B ein Bewerber)
    * @var int
    */
    const EXTERN = 4;
    
/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var array
    */
    public static $labels = [
        self::INTERNAL => 'Internal',
        self::PARTNER => 'Partner',
        self::CUSTOMER => 'Customer',
        self::EXTERN => 'Extern',
    ];

   /**
    * @param string $key
    * @return string
    */
    public static function label($key)
    {

        $i18n = BuizCore::$env->getI18n();

        return isset(self::$labels[$key])
          ? $i18n->l(self::$labels[$key],'buiz.base')
          : null; // sollte nicht passieren

    }//end public static function label */


}//end class EUserRelation

