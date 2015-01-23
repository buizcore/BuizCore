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
 * Die Dauer eines Vorgangs aus dem Start und Endedatum heraus berechnen
 * 
 * @package net.webfrap
 */
class FormatState
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
    * @param float $number
    * @param int $decimals
    */
    public static function warn($value, $negate = false)
    {
        
        if (is_bool($value)) {
            $isTrue = $value;
        } else {
            if ('f'==$value) {
                $isTrue = false;
            } else {
                $isTrue = (boolean)$value;
            }
        }
        
        if ($negate) {
            return ($isTrue)?'':' warn ';
        } else {
            return ($isTrue)?' warn ':'';
        }
    
    }//end public static function format */

} // end class FormatNumber
