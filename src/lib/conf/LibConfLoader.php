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


/** @example

    // get in gateway und liefert die Variable aus Gateway: lists/import/importable_tables.php
    $confLoader = new LibConfLoader();
    $config = $confLoader->load('lists/import/importable_tables.php');

*/

/**
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class LibConfLoader
{
    
    /**
     * @param string $file
     * @throws Io_Exception wenn die datei fehlt
     */
    public function load($file, $alternativ = null)
    {
        
        $filePath = PATH_GW.'conf/'.$file;
        
        if (file_exists($filePath)) {
            include $filePath;
            
            // es wird nur zurückgegeben was in data steht
            // data wird nicht gesetzt um später evaluieren zu können ob 
            // tatsächlich eine data variable in der conf datei vorhanden war
            if (isset($data)) {
                return $data;
            }
        } else {
                
            if ($alternativ) {
                $filePath = $alternativ.'/conf/'.$file;
                
                Log::debug('search alternative '.$filePath);
                
                if(file_exists($filePath)){
                    
                    Log::debug('load '.$filePath);
                    
                    include $filePath;
                    if (isset($data)) {
                        
                        Log::debug('found data ');
                        
                        return $data;
                    }
                }
            }
        }
        
        return null;
        
    }
 
} // end class LibConfLoader


