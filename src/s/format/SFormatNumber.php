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
class SFormatNumber
{

  /**
   *
   */
  public static function formatMoney($data)
  {
    return number_format($data,2,',','.');
  }//end public static function formatMoney */

  /**
   * @param int $value
   * @return string
   */
  public static function formatFileSize($value)
  {

    if (!$value)
      return '-';

    $labels = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
    $key = (int)floor(log($value)/log(1024));

    return sprintf('%.2f '.$labels[$key], ($value/pow(1024, floor($key))));

    //return ($value/pow(1024, floor($key))).$labels[$key];

  }//end public static function formatFileSize */

} // end class SFormatNumbers

