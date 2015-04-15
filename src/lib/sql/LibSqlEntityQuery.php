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
class LibSqlEntityQuery extends LibSqlCriteria
{
/*////////////////////////////////////////////////////////////////////////////*/
// const
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Standardkonstruktor bekommt den Namen der Query übergeben
     *
     * @param string $name Name der Query
     * @param LibSqlConnection $db Name der Query
     *
     * @return void
     */
    public function __construct($entityKey, $db = null)
    {

        $this->name = $entityKey;
        $this->entityKey = $entityKey;
    
        if (!$db) {
            $db = BuizCore::$env->getDb();
        }
    
        $this->db = $db;
    
    } // end public function __construct */
 

}//end class LibSqlEntityQuery

