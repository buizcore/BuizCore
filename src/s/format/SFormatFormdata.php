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
class SFormatFormdata
{

 /** Checkbox für Datenbank aufbereiten
  * @returns string
  */
  public static function checktoDb($vorhanden)
  {
    $vorhanden = (bool) $vorhanden;

    return $vorhanden ? "1" : "0";
  }

 /** Datenbank in Checkbox umbauen
  * @returns string
  */
  public static function dbtoCheck($Num)
  {
    $Num = (bool) $Num;

    return $Num ? "checked=\"checked\"" : "";
  }

} // end of IncFormatFormdata

