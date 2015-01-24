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
 * Download Klasse für WebFrap
 * 
 * @package net.buiz
 */
class LibSetup_Postgresql extends BaseChild
{
    
    /**
     * @param Pbase $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }//end public function __construct */
    

    /**
     * 
     */
    public function setUpDatabase()
    {
        
        // setup connection
        $conf = $this->getConf();
        $adminConf = $conf->getResource('db','admin');
        
        
        $db = Db::connection('setup');
        
        $dbConf = array(
            'class'    => 'PostgresqlPersistent',
            'dbhost'   => $adminConf['dbhost'],
            'dbport'   => $adminConf['dbport'],
            'dbname'   => 'postgresql', // erst mal auf die def datenbank connecten
            'dbuser'   => $adminConf['dbuser'],
            'dbpwd'    => $adminConf['dbpwd'],
            //'dbschema' => 'bc_app_projects',
            'quote'    => 'single'
        );
        
        $setupCon = new LibDbPostgresql($dbConf);
        
        
        
        $sql = <<<SQL
CREATE DATABASE buiznodes
  WITH OWNER = buiznodes
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'de_DE.UTF-8'
       LC_CTYPE = 'de_DE.UTF-8'
       CONNECTION LIMIT = -1;
SQL;
        
    }
    
    
} // end class LibDownload

