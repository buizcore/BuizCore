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
class FormatDateDuration
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    public static  $formData = array(
      'day' => 1,
      'week' => 7,
      'month' => 30,
      'year' => 365,
    );
    
    public static  $formTime = array(
        'second' => 1,
        'minute' => 60,
        'hour' => 3600,
        'day' => 86400,
        'week' => 604800,
        'year' => 31536000,
    );
  
    /**
     * @param string:Date $start
     * @param string:Date $end
     * @param string $format
     */
    public function formatRowTimestamp($row, $table, $start, $end, $format = null)
    {
        // wenn start oder ende fehlen, dann 0 per definition
        if (!$start ||!$end)
            return '0';
    
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
    
        $dur = $startDate->diff($endDate);
        
        $hour = $dur->format('%h');
        
        return str_pad($dur->format('%h'), 2, '0', STR_PAD_LEFT)
            .':'.str_pad($dur->format('%i'), 2, '0', STR_PAD_LEFT)
            .':'.str_pad($dur->format('%s'), 2, '0', STR_PAD_LEFT);

    
    }//end public static function formatRowTimestamp */
    
    /**
     * @param string:Date $start
     * @param string:Date $end
     * @param string $format
     */
    public function formatRowTime($row, $table, $start, $end, $format = null)
    {
    
        // wenn start oder ende fehlen, dann 0 per definition
        if (!$start ||!$end)
            return '0';
        
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        
        $dur = $startDate->diff($endDate);
        
        $hour = $dur->format('%h');
        
        return str_pad($dur->format('%h'), 2, '0', STR_PAD_LEFT)
        .':'.str_pad($dur->format('%i'), 2, '0', STR_PAD_LEFT)
        .':'.str_pad($dur->format('%s'), 2, '0', STR_PAD_LEFT);
    
    }//end public static function formatRowTime */
    
    /**
     * @param string:Date $start
     * @param string:Date $end
     * @param string $format
     */
    public function formatRowDate($row, $table, $start, $end, $format = 'day')
    {
    
         
        // wenn start oder ende fehlen, dann 0 per definition
        if (!$start ||!$end)
            return '0';
    
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
    
        $dur = $startDate->diff($endDate);
    
        return floor($dur->format('%a')/self::$formData[$format]) ;
    
    }//end public static function formatRowDate */
    
  /**
   * @param string:Date $start
   * @param string:Date $end
   * @param string $format
   */
  public static function format($start, $end, $format = 'month')
  {
    
   
    
    
    // wenn start oder ende fehlen, dann 0 per definition
    if (!$start ||!$end)
      return '0';
    
    $startDate = new DateTime($start);
    $endDate = new DateTime($end);
    
    $dur = $startDate->diff($endDate);
    
    return floor($dur->format('%a')/self::$formData[$format]) ;
    
  }//end public static function format */

} // end class FormatDateDuration
